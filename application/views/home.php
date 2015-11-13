<?php $this->load->view('/partials/head') ?>
<?php if ($this->session->userdata('logged')) {
		$user = $this->session->userdata('logged');
	} ?>
<a href="/users/logout">Logout</a>
<h1>Hello, <?= $user['first_name'] ?>!</h1>
<?php if(!empty($friends)) { ?> 
	<p>Here is the list of friends: </p>
	<div id="errors">
	<?php if($this->session->flashdata('errors')){
		echo $this->session->flashdata('errors');
		}?>
	</div>
	<div id = "friend_list">
		<table class="table table-striped  table-bordered">
			<th>Name</th>
			<th>Action</th>
			<?php foreach ($friends as $friend) {  ?>
			<tr>
				<td><?= $friend['first_name'] . ' ' . $friend['last_name']?></td>
				<td>
				<a href=<?php echo "/users/profile/" . $friend['friend_id'] ?> >View Profile</a> | 
				<a href=<?php echo "/users/remove/" . $friend['friend_id'] ?>>Remove Friend</a>	
				</td>
			</tr>
				<?php } ?>
		</table>
		<?php } else { ?>
		<p>You have no friends yet</p>
		<?php } ?>
</div>
<div id="other_users">
	<table class="table table-striped  table-bordered">
		<th>Name</th>
		<th>Action</th>
		<?php foreach ($others as $other) { ?>
			<tr>
				<td>
					<a href=<?php echo "/users/profile/" . $other['id'] ?> > <?= $other['first_name']?> </a>
				</td>
				<td>
				<a class="btn-primary btn-sm" href=<?php echo "/users/add/" . $other['id'] ?> >Add as friend</a>
				</td>
			</tr>
		<?php } ?>
	</table>
</div>
</body>
</html>