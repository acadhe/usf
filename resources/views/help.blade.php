@extends('templates.master')
@section('content')
		<section id="atas-help">
			<div class="container">
				<div class="row">
					<div class="col m8" id="head-utama-help">
						<h4>Help</h4>
						<p>Learn How To Use UCP</p>
					</div>
					<div class="col m4">
						<form>
							<nav>
								<div class="nav-wrapper">
								  <form>
									<div class="input-field cari-box">
									  <input id="search" type="search" name="keyword" class="form-control input-sm">
									  <label for="search"><i class="material-icons mat-ico-black">search</i></label>
									  <!-- <button class="btn btn-primary" type="submit">Cari</button> -->
									  <i class="material-icons">close</i>
									</div>
								  </form>
								</div>
							  </nav>
						</form>
					</div>
				</div>
			</div>
		</section>
		<section id="bawah-help">
			<div class="container cards" id="help-bg-layer">
				<div class="row" >
					<div class="col s12 m12" id="card-help">
						<div class="card">
							<div class="card-content">
								<div class="wrapper-card-help context">
									<ul class="collapsible" data-collapsible="expandable">
										<li>
											<div class="collapsible-header active"><h5>First</h5></div>
											<div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
										</li>
										<li>
											<div class="collapsible-header active"><h5>Second</h5></div>
											<div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
										</li>
										<li>
											<div class="collapsible-header active"><h5>Third</h5></div>
											<div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/7.0.2/jquery.mark.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/7.0.2/mark.min.js"></script>
<script>

</script>
@endsection