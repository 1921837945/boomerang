<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.3 - laravel scout algolia search example</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Laravel Full Text Search using Scout and algolia</h2><br/>
    <form method="POST" action="{{ route('create-item') }}" autocomplete="off">
        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title" value="{{ old('title') }}">
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button class="btn btn-success">Create New Item</button>
                </div>
            </div>
        </div>
    </form>

    <div class="panel panel-primary">
        <div class="panel-heading">Item management</div>
        <div class="panel-body">
            <form method="GET" action="{{ route('items-lists') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Enter Title For Search" value="{{ old('search') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-success">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                <th>物品Id</th>
                <th>提交人Id</th>
                <th>物品名称</th>
                <th>物品详情</th>
                <th>丢失地点</th>
                <th>类别</th>
                <th>图片</th>
                <th>联系电话</th>
                <th>联系QQ</th>
                <th>浏览次数</th>
                <th>创建时间</th>
                <th>修改时间</th>
                </thead>
                <tbody>
                @if($items->count())
                    @foreach($items as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->u_id }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->item_des }}</td>
                            <td>{{ $item->item_lost_place }}</td>
                            <td>{{ $item->type_id }}</td>
                            <td>{{ $item->img_url }}</td>
                            <td>{{ $item->contact_phone }}</td>
                            <td>{{ $item->contact_qq }}</td>
                            <td>{{ $item->view_count }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12">There are no data.</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
</div>
</body>
</html>