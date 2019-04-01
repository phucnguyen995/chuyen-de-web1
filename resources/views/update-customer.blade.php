<h3>Thông tin hành khách : </h3>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $i = 1; ?>
            @foreach($data['get_customer_by_book_id'] as $key)
                <h4>Hành khách #{{$i}}</h4>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label">Title:</label>
                        <select class="form-control" name="title{{$i}}">
                            <option value="mr">Mr.</option>
                            <option value="mrs">Mrs.</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="control-label">First Name:</label>
                        <input type="text" value="{{ $key->customer_first_name}}" required name="first_name{{$i}}" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">Last Name:</label>
                        <input type="text" value="{{ $key->customer_last_name}}" required name="last_name{{$i}}" class="form-control">
                    </div>
                </div>
                <?php $i++; ?>
            @endforeach
            <button type="submit" class="btn btn-success">Cập nhật thông tin hành khách</button>
        </div>
        
    </div>