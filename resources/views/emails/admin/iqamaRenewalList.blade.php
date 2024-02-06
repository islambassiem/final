<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      font-size: 20px;
      width: 100%;
      text-align: center;
      direction: rtl;
    }

    td, th {
      border: 1px solid rgb(185, 185, 185);
      text-align: right;
      padding: 10px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>الرقم الوظيفي</th>
        <th>الإسم</th>
        <th>الكفالة</th>
        <th>رقم الاقامة</th>
        <th>تاريخ الانتهاء</th>
        <th>الانتهاء بعد</th>
      </tr>
    </thead>
    <tbody>
      @php $c = 1; @endphp
      @foreach ($iqamas as $iqama)
      <tr>
        <td>{{ $c }}</td>
        <td>{{ $iqama->user->empid }}</td>
        <td>{{ $iqama->user->getFullArabicNameAttribute }}</td>
        <td>{{ $iqama->user->sponsorship->sponsorship_ar }}</td>
        <td>{{ $iqama->document_id }}</td>
        <td>{{ $iqama->date_of_expiry }}</td>
        <td>{{ $iqama->getExpiryAttribute() . ' أيام'}}</td>
      </tr>
      @php $c++; @endphp
      @endforeach
    </tbody>
  </table>
</body>
</html>