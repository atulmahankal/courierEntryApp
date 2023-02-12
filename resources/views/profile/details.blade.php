<div class="col-md-9">
  <div class="card">
    <div class="card-body">
      <form class="form-horizontal">
        @method('put')
          <div class="form-group row">
            <label for="name" class="col-sm-3">Name</label>
						<div  class="col-sm-9">
						<input type="name" name="password" class="form-control" id="name" placeholder="">
						</div>
          </div>
          <div class="form-group row">
            <label for="emailaddress" class="col-sm-3">E-mail Address</label>
						<div  class="col-sm-9">
						<input type="email" name="password" class="form-control" id="emailaddress" placeholder="">
						</div>
          </div>
					<button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
