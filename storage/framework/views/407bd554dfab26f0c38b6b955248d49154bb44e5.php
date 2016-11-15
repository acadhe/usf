<?php $__env->startSection('content'); ?>

<section id="atas-home">
	<div class="row">
		<div class="col s12 m12" id="wrapper-card">
			<div id="wrapper-home-img">
				<div class="container wrapper-card-content">
					<h5>A home for urban enthusiasts to explore urban issues, discover ideas, and exchange perspectives.</h5>
					<?php if(Auth::guest()): ?>
						<h5>Sign up to read and interact with what matters most to you</h5>
						<a href="<?php echo e(route('auth.login')); ?>" class="waves-effect waves-light btn signup">Join the discussions</a>
					<?php endif; ?>
					<a href="<?php echo e(route('home.about')); ?>" class="waves-effect waves-light btn lhiw">Learn More</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="bawah-home">
	<div class="container cards" id="height-bg-layer">
		<div class="row">
			<div class="col s12 m12" id="wrapper-card">
				<div class="card">
					<div class="card-content">
						<form action="<?php echo e(route("home")); ?>" method="get" id="form">
							<div class="row" id="row-cards">
								<div class=" input-field col s12 m3">
									<div class="asd">
										<p class="select-p">Sort Discussion</p>
										<select name="sort" class="form-control onchange-submit-form">
											<option value="most_recent" <?php if($filter['sort'] == 'most_recent'): ?> selected <?php endif; ?>>Most Recent</option>
											<option value="most_popular" <?php if($filter['sort'] == 'most_popular'): ?> selected <?php endif; ?>>Most Popular</option>
										</select>
									</div>
								</div>
								<div class="input-field col s12 m2">
									<div class="asd">
										<p class="select-p">Panelists <?php echo e(old('panelist')); ?></p>
										<select name="panelist_id" class="form-control onchange-submit-form">
											<option value="all" <?php if(request('panelist')=="all"): ?> selected <?php endif; ?>>All</option>
											<?php foreach($panelists as $panelist): ?>
												<option value="<?php echo e($panelist->id); ?>" <?php if(request('panelist_id')==$panelist->id): ?> selected <?php endif; ?>><?php echo e($panelist->name); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="input-field col s12 m4" id="cat">
									<div class="asd">
										<p class="select-p">Categories</p>
										<select name="category" class="form-control onchange-submit-form" >
											<option value="all" <?php if(request('category')=="all"): ?> selected <?php endif; ?> >All</option>
											<?php foreach($categories as $category): ?>
												<option value="<?php echo e($category->name); ?>" <?php if(request('category')==$category->name): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<?php /* <div class="input-field col s12 m3">
									<nav id="nav-search">
										<div class="nav-wrapper">
											<div class="input-field" id="cari-dpn">
												<i class="material-icons" id="cari-mask">search</i>
												<input id="search" name='search' type="search" value="<?php echo e(request('search')); ?>" class="cari" placeholder="Search for discussion title or panelist name">
												<label for="search"><i class="material-icons" id="cari-hid">search</i></label>
												<i class="material-icons" id="close">close</i>
												<input type="submit" value="Cari" style="display: none"/>
											</div>
										</div>
									</nav>
								</div> */ ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container cards" id="bawah-home-cards">
		<div class="row">
			<?php foreach($articles as $article): ?>
				<?php echo $__env->make("templates.articles.card",['article'=>$article,'user'=>$article->user], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php /*<?php echo $articles->appends($filter)->render(); ?>*/ ?>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
@parent
<script>
$(".onchange-submit-form").change(function(){
	console.log("woi");
	$("#form").submit();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>