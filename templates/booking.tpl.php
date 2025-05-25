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


<?php
function drawReviewForm($booking): void {
    // Verifica se a reserva está completa
    if ($booking['status'] === 'completo'): ?>
        <div class="rating-form">
            <h3>Leave a Review</h3>
            <form action="../actions/action_review.php" method="POST">
                <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">

                <label for="rating">Rating (0-5):</label>
                <input type="number" name="rating" min="0" max="5" required>

                <label for="comment">Comment:</label>
                <textarea name="comment" required></textarea>

                <button type="submit">Submit Review</button>
            </form>
        </div>
    <?php endif; 
}
?>