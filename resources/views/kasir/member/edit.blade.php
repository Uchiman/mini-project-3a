@extends('templates.default')

@section('content')

    <div class="col-md-6" style="margin-left: 25%">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Member</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="/kasir/member/{{ $member->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body">

                    <div class="form-group  @error('nama') has-error @enderror">
                        <label for="nama">Nama Member</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama member"
                            value="{{ old('nama') ?? $member->nama }}">
                        @error('nama')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group  @error('no_hp') has-error @enderror">
                        <label for="no_hp">Nomer Hp Member</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            placeholder="Masukkan nomer hp member" value="{{ old('no_hp') ?? $member->no_hp }}">
                        @error('no_hp')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
