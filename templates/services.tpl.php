

<?php function add_Service_Form(Session $session, array $categories) {?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Add Service</title>
        <link rel="stylesheet" href="../css/add_service.css"> <!-- Cria este ficheiro ou cola o CSS que te dou já a seguir -->
    </head>
    <section class="form-wrapper">
        <h2>Add a New Service</h2>
        <form class="add-service-form" action="../actions/action_add_service.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" required>
            <label for="category">Category:</label>
            <select name="category_name" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category_name']) ?>">
                        <?= htmlspecialchars($category['category_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="duracao">Duration (minutes):</label>
            <input type="number" name="duracao" min="1" required>

            <label for="price">Price (€):</label>
            <input type="number" name="price" step="0.01" min="0" required>

            <label for="service_type">Service Type:</label>
            <select name="service_type" required>
                <option value="individual presencial">Individual Presencial</option>
                <option value="grupo presencial">Grupo Presencial</option>
                <option value="individual online">Individual Online</option>
                <option value="grupo online">Grupo Online</option>
                <option value="revisão trabalhos">Revisão de Trabalhos</option>
            </select>

            <label for="num_sessoes">Number of Sessions:</label>
            <input type="number" name="num_sessoes" min="1" required>

            <label for="max_students">Max Students (group services only):</label>
            <input type="number" name="max_students" min="1" placeholder="Optional">

        
            <button type="submit" class="submit-btn">Publish Service</button>
        </form>
    </section>

<?php } ?>


<?php function drawServices(array $services){ ?>
    <section id="services">
        <h2>Services Available</h2>
        <div class="services-button">
            <?php foreach ($services as $service) { 
                $profileImage = $service['profile_image']; // Caminho da imagem
            ?>
                <div class="service-card">
                    <!-- Exibe a imagem do freelancer -->
                    <div class="service-img-container">
                        <img class="profile-photo" src="<?= htmlspecialchars($profileImage) ?>" alt="Foto de <?= htmlspecialchars($service['freelancer_name']) ?>">
                    </div>
                    <div class="service-details">
                        <p class="service-name"><h3><?= htmlspecialchars($service['title']) ?><h3>
                        <p class="service-description"><?= htmlspecialchars($service['description']) ?>                           
                        <p class="freelancer-name">@<?= htmlspecialchars($service['freelancer_name']) ?></p>
                        <p class="price">€<?= number_format($service['price'], 2) ?></p>
                        <p class="rating">
                            <?php 
                            $avg = round($service['avg_rating'], 1);
                            if ($avg) {
                                echo $avg . " ★";
                            } else {
                                echo "No reviews";
                            }
                            ?>
                        </p>
                        <a href="service_detail.php?id=<?= $service['service_id'] ?>" class="view-service-btn">View Service</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>



<?php function drawServiceDetail($service, $freelancer, $reviews) { ?>
<section id="service-detail">
  <h1><?= htmlspecialchars($service->title) ?></h1>

  <div class="freelancer-info">
    <img src="<?= htmlspecialchars($freelancer->getPhoto()) ?>" alt="Photo of <?= htmlspecialchars($freelancer->name) ?>" />
    <h2><?= htmlspecialchars($freelancer->name) ?></h2>
    <p><?= nl2br(htmlspecialchars($freelancer->biography ?? '')) ?></p>
  </div>

  <div class="service-info">
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($service->description)) ?></p>
    <p><strong>Duration:</strong> <?= htmlspecialchars($service->duracao) ?> minutos</p>
    <p><strong>Price:</strong> €<?= number_format($service->price, 2) ?></p>
    <p><strong>Type of service:</strong> <?= htmlspecialchars($service->service_type) ?></p>
    <p><strong>Number of sessions:</strong> <?= htmlspecialchars($service->num_sessoes) ?></p>
  </div>

  <div class="booking-form">
    <h3>Mark Service</h3>
    <form action="../actions/action_booking.php" method="POST">
      <input type="hidden" name="service_id" value="<?= $service->service_id ?>" />
      <?php for ($i = 1; $i <= $service->num_sessoes; $i++): ?>
      <label for="date<?= $i ?>">Date of session <?= $i ?>:</label>
      <input type="date" id="date<?= $i ?>" name="dates[]" required />
    <?php endfor; ?>

      <label for="payment_method">Payment method:</label>
      <select name="payment_method" id="payment_method" required>
        <option value="MBWAY">MBWAY</option>
        <option value="VISA">VISA</option>
        <option value="PayPal">PayPal</option>
        <option value="Apple Pay">Apple Pay</option>
      </select>

      <button type="submit">Confirm reservation</button>
    </form>
  </div>

  <div class="reviews">
    <h3>Reviews</h3>
    <?php if (count($reviews) === 0) { ?>
      <p>No reviews yet.</p>
    <?php } else {
      foreach ($reviews as $review) { ?>
        <div class="review">
          <p><strong>Rating:</strong> <?= htmlspecialchars($review->rating) ?> ★</p>
          <p><?= nl2br(htmlspecialchars($review->comment)) ?></p>
          <small>Data: <?= htmlspecialchars($review->data_avaliacao) ?></small>
        </div>
    <?php }
    } ?>
  </div>
</section>
<?php } ?>
