<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">

	<?php $this->load->view("admin/_partials/navbar.php") ?>
	<div id="wrapper">

		<?php $this->load->view("admin/_partials/sidebar.php") ?>
		<?php // Cara menampilkan variable session
		// echo $this->session->userdata('email'); ?>
		<div id="content-wrapper">

			<div class="container-fluid">

				<?php $this->load->view("admin/_partials/breadcrumb.php") ?>
				<!-- DataTables -->
				<div class="card mb-3">
					<div class="card-header">
						<a href="<?php echo site_url('admin/documents/add/') ?>"><i class="fas fa-plus"></i> Add New</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Name</th>
										<th>Category</th>
										<th>Document</th>
                                        <th>Description</th>
                                        <th>Download</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($documents as $document): ?>
									<tr>
										<td width="150">
											<?php echo $document->name ?>
										</td>
										<td>
											<?php echo $document->category ?>
										</td>
										<td>
										<?php echo $document->document ?>
										</td>
										<td class="small">
                                            <?php echo substr($document->description, 0, 120) ?>...</td>
                                        <td width="100">
                                        <a href="<?php echo site_url('upload/documents/'.$document->document) ?>"
											 class="btn btn-small"><i class="fas fa-download"></i> Download</a>
                                        </td>
									</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			<!-- /.container-fluid -->

			<!-- Sticky Footer -->
			<?php $this->load->view("admin/_partials/footer.php") ?>

		</div>
		<!-- /.content-wrapper -->

	</div>
	<!-- /#wrapper -->


	<?php $this->load->view("admin/_partials/scrolltop.php") ?>
	<?php $this->load->view("admin/_partials/modal.php") ?>

	<?php $this->load->view("admin/_partials/js.php") ?>

	<script>
	function deleteConfirm(url){
		$('#btn-delete').attr('href', url);
		$('#deleteModal').modal();
	}
	</script>
</body>

</html>
