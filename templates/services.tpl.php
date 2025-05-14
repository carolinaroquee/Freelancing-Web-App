

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

            <label for="service_images">Upload Images:</label>
            <input type="file" name="service_images[]" id="service-images" accept="image/*" multiple> <!-- Permite múltiplos arquivos de imagem -->

            <button type="submit" class="submit-btn">Publish Service</button>
        </form>
    </section>

<?php } ?>


<?php function drawServices(array $services){ ?>
    <section id="services">
        <h2>Services Available</h2>
    
        <?php foreach ($services as $service){?>
            
            <button class = "service-button">
                <img src= "<?= $service['images'] ?>" >
                <span> <?= $service['title'] ?>: <?= $service['category_name']?> </span>
            </button>
        <?php } ?>

    </section>

<?php } ?>
