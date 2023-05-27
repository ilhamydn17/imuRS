<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input Unit</title>
</head>
<body>

    <form action="{{ route('unit.store') }}" method="post">
        @csrf
       <label for="">Nama Unit</label>
       <input type="text" name="nama_unit">
        <button type="submit">simpan</button>
    </form>

</body>
</html>
