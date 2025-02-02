<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

$events = $conn->query("SELECT * FROM events ORDER BY date DESC");
?>

<?php include('header.php'); ?>

<div class="container mt-4">
    <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
    <p>You are logged in as: <strong><?php echo ucfirst($user_role); ?></strong></p>

    <!-- Create Event Button -->
    <a href="event/create.php" class="btn btn-primary mb-3">Create Event</a>

    <!-- Search Box with Search Button -->
    <div class="mb-3 mt-3">
        <div class="input-group">
            <input type="text" id="searchBox" class="form-control" placeholder="Search for events...">
            <button id="searchButton" class="btn btn-primary" type="button">Search</button>
        </div>
        <div id="searchResults" class="list-group mt-1"></div>
    </div>

    <!-- Event List -->
    <h3 class="mt-4">Event List</h3>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Event Type</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events->num_rows > 0): ?>
                <?php $count = 1; ?>
                <?php while ($event = $events->fetch_assoc()): ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= htmlspecialchars($event['name']); ?></td>
                        <td><?= htmlspecialchars($event['description']); ?></td>
                        <td><?= htmlspecialchars($event['date']); ?></td>
                        <td><?= htmlspecialchars($event['event_time']); ?></td>
                        <td><?= htmlspecialchars($event['event_type']); ?></td>
                        <td><?= htmlspecialchars($event['capacity']); ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-success view-event-btn" data-id="<?= $event['id'] ?>">View</a>
                            <a href="event/edit.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="event/delete.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                            <a href="event/register.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-info">Register</a>
                            <?php if ($user_role == 'admin'): ?>
                                <a href="csv.php?event_id=<?= $event['id'] ?>" class="btn btn-sm btn-dark">Download Report</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No events available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Viewing Event Details -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventDetails">
                <!-- Event details will be dynamically loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
    // Function to load event details into the modal
    function loadEventDetails(eventId) {
        fetch(`event/viewevent.php?id=${eventId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const event = data.event;
                    const attendees = data.attendees;

                    let attendeesList = attendees.length ? attendees.map(attendee =>
                        `<li>${attendee.name} (${attendee.email})</li>`
                    ).join('') : '<li>No attendees registered.</li>';

                    document.getElementById('eventDetails').innerHTML = `
                        <h4>${event.name}</h4>
                        <p><strong>Description:</strong> ${event.description}</p>
                        <p><strong>Date:</strong> ${event.date}</p>
                        <p><strong>Time:</strong> ${event.event_time}</p>
                        <p><strong>Event Type:</strong> ${event.event_type}</p>
                        <p><strong>Capacity:</strong> ${event.capacity}</p>
                        <h5>Attendees:</h5>
                        <ul>${attendeesList}</ul>
                    `;

                    const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    eventModal.show();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Attach click event for existing view buttons
    document.querySelectorAll('.view-event-btn').forEach(button => {
        button.addEventListener('click', function() {
            loadEventDetails(this.getAttribute('data-id'));
        });
    });

    // Search Function triggered by typing or clicking the search button
    function performSearch() {
        const query = document.getElementById('searchBox').value.trim();

        if (query.length > 1) {
            fetch(`event/searchevent.php?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const searchResults = document.getElementById('searchResults');
                    searchResults.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(event => {
                            const item = document.createElement('a');
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = `<strong>${event.name}</strong> - ${event.description} <span class="text-muted">(${event.event_type})</span>`;
                            item.setAttribute('data-id', event.id);

                            item.addEventListener('click', function() {
                                loadEventDetails(event.id);
                                searchResults.innerHTML = '';  // Clear suggestions after selection
                            });

                            searchResults.appendChild(item);
                        });
                    } else {
                        searchResults.innerHTML = '<div class="list-group-item">No matches found.</div>';
                    }
                });
        } else {
            document.getElementById('searchResults').innerHTML = '';
        }
    }

    // Trigger search on typing
    document.getElementById('searchBox').addEventListener('keyup', performSearch);

    // Trigger search on button click
    document.getElementById('searchButton').addEventListener('click', performSearch);
</script>

