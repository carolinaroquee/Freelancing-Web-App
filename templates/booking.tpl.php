<?php
function drawClientBookingsTable(array $bookings): void {
    ?>
    
    <h1>My Reservations</h1>

    <?php if (empty($bookings)): ?>
        <p>No reservation made.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #004080; color: white;">
                <tr>
                    <th>Service</th>
                    <th>Date of Reservation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['title']) ?></td>
                        <td><?= htmlspecialchars($booking['data_agendamento']) ?></td>
                        <td><?= htmlspecialchars($booking['status']) ?></td>
                        <td>
                            <?php
                            $hoje = date('Y-m-d');
                            if ($booking['status'] === 'pendente' && $booking['data_agendamento'] > $hoje):
                            ?>
                                <a href="../actions/action_cancel_booking.php?booking_id=<?= $booking['booking_id'] ?>" 
                                   onclick="return confirm('Are you sure you want to cancel this reservation?');">
                                   Cancel
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif;
}
?>
