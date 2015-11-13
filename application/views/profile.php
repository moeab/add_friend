<?php $this->load->view("/partials/head")?>
<a href="/users/home">Home</a> | 
<a href="/users/logout">Logout</a>
<h1><?= $profile['first_name']?>'s Profile</h1>
<p>Name: <?php echo $profile['first_name'] . ' ' . $profile['last_name'] ?></p>
<p>Email Address: <?= $profile['email'] ?></p>
</body>
</html>