<?php
use App\Models\Article;
?>
<?php echo csrf_field(); ?>

<div class="container" id="wrapper-form-create">
	<div class="row">
		<div class="col m12" id="form-post">
			<textarea name="title" class="post-judul materialize-textarea" id="" value="<?php echo e(old('title',$article->title)); ?>" placeholder="Title"><?php echo e($article->title); ?></textarea>
			<?php /* <input name="title" type="text"  > */ ?>
			<p class="error-message"><?php echo e($errors->first('title')); ?></p>
			<div id="form-select">
				<select name="category">
					<?php foreach($categories as $category): ?>
						<option value="<?php echo e($category->name); ?>" <?php if(old('content',$article->category)==$category->name): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="activator">
				<?php if($article->header_image_url == null): ?>
					<img src="<?php echo e(asset('frontend/img/rectangle-9.png')); ?>" class="responsive-img" id="headerimg-preview">
					<div class="up-btn">
						<div class="btn">
							<span>Browse File</span>
							<input name="headerimg" type="file" data-max-size="5000" title="Choose your header image">
						</div>
					</div>
				<?php else: ?>
					<img src='<?php echo e($article->header_image_url); ?>' class="responsive-img" id="headerimg-preview">
					<span class="info-img-up">
						Change Image Header (max. 2MB)
						<i class="material-icons">add_a_photo</i>
					</span>
					<div class="up-btn">
						<div class="btn">
							<span>Browse File</span>
							<input name="headerimg" type="file" data-max-size="5000" title="Choose your header image">
						</div>
					</div>
				<?php endif; ?>
				<p class="error-message"><?php echo e($errors->first('headerimg')); ?></p>
			</div>
			<p class="error-message"><?php echo e($errors->first('content')); ?></p>
			<textarea name="content" class="editable validates" placeholder="konten" id="editable">
				<?php echo e(old('content',$article->content)); ?>

			</textarea>
			<input name="image" type="file" id="upload" class="hide" onchange="">
			<input id='privacy' type="hidden" name="privacy" value="<?php echo e($article->privacy); ?>" />
			<?php /*input social media connection to be submitted. the value will be gotten from the navbar using jquery*/ ?>
			<input type="hidden" name="share_facebook"/>
			<input type="hidden" name="share_twitter"/>
			<input type="hidden" name="share_google_plus"/>
		</div>
	</div>
</div>

<div id="alert-modal" class="modal">
	<div class="modal-content">
		<h4>File yang Anda pilih melebihi dari ukuran 5MB. <br> Silahkan pilih kembali file yang ukurannya kurang dari 5MB.</h4>
		<p>Silahkan klik diluar kotak ini untuk memilih gambar kembali</p>
	</div>
</div>

<?php $__env->startSection('scripts'); ?>
	@parent
	<script>
		tinymce.init({
		  selector: '.editable',
		  auto_focus: 'editable',
		  height: 500,
		  theme: 'modern',
		  target_list: false,
		  default_link_target: "_blank",
		  media_alt_source: false,
		  media_poster: false,
		  media_dimensions: false,
		  image_dimensions: false,
		  statusbar: false,
		  preformatted : false,
		  plugins: [
			'autolink lists link image charmap preview hr pagebreak autoresize',
			'searchreplace wordcount fullscreen',
			'insertdatetime media nonbreaking save contextmenu directionality',
			'paste textcolor colorpicker textpattern imagetools'
		  ],
		  menu: {
			// edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
			// insert: {title: 'Insert', items: 'link media | template hr'},
		  },
		  toolbar: 'insertfile | undo | redo | formatselect | blockquote | bold | italic | underline | alignleft | aligncenter | alignright | alignjustify | strikethrough | superscript | subscript | bullist | numlist | outdent | indent | link | image | media',
		  // advlist_number_styles: "lower-alpha,lower-roman,upper-alpha,upper-roman",
		  file_picker_types: 'image',
		  file_picker_callback: function(callback, value, meta) {
			  if (meta.filetype == 'image') {
				$('#upload').trigger('click');
				$('#upload').on('change', function() {
				  var file = this.files[0];
				  var reader = new FileReader();
				  reader.onload = function(e) {
					callback(e.target.result, {
					  alt: ''
					});
				  };
				  reader.readAsDataURL(file);
				});
			  }
			},
			images_upload_handler: function (blobInfo, success, failure) {
				var xhr, formData;

				xhr = new XMLHttpRequest();
				xhr.withCredentials = false;
				xhr.open('POST', '/images/articles/<?php echo e($article->id); ?>/upload');

				xhr.onload = function() {
					var json;
					console.log("upload success");
					if (xhr.status != 200) {
						failure('HTTP Error: ' + xhr.status);
						return;
					}

					json = JSON.parse(xhr.responseText);

					if (!json || typeof json.url != 'string') {
						failure('Invalid JSON: ' + xhr.responseText);
						return;
					}
					success(json.url);
				};

				formData = new FormData();
				formData.append('image', blobInfo.blob(), blobInfo.filename());
				formData.append('_token','<?php echo e(csrf_token()); ?>');

				xhr.send(formData);
				console.log("sending data....");
		  },
		  content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			// '//www.tinymce.com/css/codepen.min.css',
			'../../../frontend/css/tiny.css'
		  ]
		 });
	</script>
	<script>
		$(".chk-sosmed input[type=checkbox]").change(function(e){
			var checked = $(this).prop("checked");
			var id = $(this).attr("id");
			if (id == 'fb'){
				$("input[name=share_facebook]").val(checked);
			} else if(id == 'tw'){
				$("input[name=share_twitter]").val(checked);
			} else if (id == 'gp'){
				$("input[name=share_google_plus]").val(checked);
			}
		});
		$("#publish-post-draft").click(function(){
			$("#privacy").val('<?php echo e(Article::PRIVACY_DRAFT); ?>');
			$("form#form").submit();
		});
		$(".publish-post-submit").click(function(){
			$("#privacy").val('<?php echo e(Article::PRIVACY_PUBLISHED); ?>');
			$("form#form").submit();
		});
		$(".draft-post").click(function(){
			$("#privacy").val('<?php echo e(Article::PRIVACY_DRAFT); ?>');
			$("form#form").submit();
		});
//		$("#save-article").click(function(){
//			$("form#form").submit();
//		});

		//for displaying selected image header file
		<?php /* http://www.html5rocks.com/en/tutorials/file/dndfiles/ */ ?>
		$("input[name=headerimg]").change(function(e){
			var f = e.target.files[0]
				fileSize = f.size;
			// Only process image files.
			if (!f.type.match('image.*')) {
				return;
			}
			console.log(fileSize + "is my file's size");
			if(fileSize > 5000000) {
				// < 5mb file will do
				$('#alert-modal').openModal();
				return false;
			}
			var reader = new FileReader();


			// Closure to capture the file information.
			reader.onload = (function(theFile) {
				return function(e) {
					// Render thumbnail.
					$("#headerimg-preview").attr('src',e.target.result);
				};
			})(f);

			// Read in the image file as a data URL.
			reader.readAsDataURL(f);
		});
	</script>
<?php $__env->stopSection(); ?>