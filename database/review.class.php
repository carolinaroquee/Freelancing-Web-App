<?php
declare(strict_types = 1);
    require_once(__DIR__. '/../templates/common.tpl.php');    
class Review {

    public int $review_id;
    public int $booking_id;
    public int $rating;
    public ?string $comment;
    public string $data_avaliacao;

    public function __construct(int $review_id, int $booking_id, int $rating, ?string $comment, string $data_avaliacao) {
        $this->review_id = $review_id;
        $this->booking_id = $booking_id;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->data_avaliacao = $data_avaliacao;
    }

    // Método para buscar todas as reviews associadas a um serviço (via booking)
    public static function getReviewsByServiceId(PDO $db, int $service_id): array {
        $stmt = $db->prepare('
            SELECT r.review_id, r.booking_id, r.rating, r.comment, r.data_avaliacao
            FROM Review r
            JOIN Booking b ON r.booking_id = b.booking_id
            WHERE b.service_id = :service_id
            ORDER BY r.data_avaliacao DESC
        ');
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        $stmt->execute();

        $reviews = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reviews[] = new Review(
                intval($row['review_id']),
                intval($row['booking_id']),
                intval($row['rating']),
                $row['comment'],
                $row['data_avaliacao']
            );
        }
        return $reviews;
    }
}
