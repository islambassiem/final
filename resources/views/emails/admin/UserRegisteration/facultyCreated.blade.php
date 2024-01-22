<table>
  <tbody>
    <tr>
      <th>Name</th>
      <td>{{ $user->getFullEnglishNameAttribute }}</td>
    </tr>
    <tr>
      <th>National ID</th>
      <td>{{ $user->iqama($user->id)->document_id }}</td>
    </tr>
    <tr>
      <th>Email</th>
      <td>{{ $user->email }}</td>
    </tr>
    <tr>
      <th>Mobile</th>
      <td>{{ $user->mobile($user->id) }}</td>
    </tr>
  </tbody>
</table>