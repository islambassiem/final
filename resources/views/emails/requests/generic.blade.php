<table cellspacing="0" cellpadding="0" border="0" style="color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica">
  <tbody>
    <tr width="100%">
      <td valign="top" align="left" style="background:#eef0f1;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica">
        <table style="border:none;padding:0 18px;margin:50px auto;width:750px">
          <tbody>
            <tr width="100%" height="60">
              <td valign="top" align="left"  colspan="2" style="border-top-left-radius:4px;border-top-right-radius:4px;background:#27709b url(https://ci5.googleusercontent.com/proxy/EX6LlCnBPhQ65bTTC5U1NL6rTNHBCnZ9p-zGZG5JBvcmB5SubDn_4qMuoJ-shd76zpYkmhtdzDgcSArG=s0-d-e1-ft#https://trello.com/images/gradient.png) bottom left repeat-x;padding:10px 18px;text-align:center">
                <img height="40" width="40" src="https://csmonline.net/assets/img/logo.png" title="Inaya" style="font-weight:bold;font-size:18px;color:#fff;vertical-align:top" class="CToWUd">
              </td>
            </tr>
            <tr width="100%">
              <td valign="top" align="left" style="background:#fff;padding:18px" colspan="2">
                <h1 style="font-size:20px;margin:16px 0;color:#333;text-align:center"> Generic Request - طلب عام </h1>
              </td>
            </tr>
            <tr width="100%">
              <td valign="top" align="left" style="background:#fff;padding:18px">
                <p style="color:#333;">Employee Name</p>
                <p style="color:#333;">إسم الموظف</p>
              </td>
              <td valign="top" align="left" style="background:#fff;padding:18px">
                <p style="color:#333;">{{ $request->user->getFullEnglishNameAttribute }}</p>
                <p style="color:#333;">{{ $request->user->getFullArabicNameAttribute }}</p>
              </td>
            </tr>
            <tr width="100%">
              <td valign="top" align="left" style="background:#fff;padding:18px">
                <p style="color:#333;">Title</p>
                <p style="color:#333;">العنوان</p>
              </td>
              <td valign="middle" align="left" style="background:#fff;padding:18px">
                <p style="color:#333;">{{ $request->title }}</p>
              </td>
            </tr>
            <tr width="100%">
              <td valign="top" align="left" style="background:#fff;padding:18px">
                <p style="color:#333;">Subject</p>
                <p style="color:#333;">الموضوع</p>
              </td>
              <td valign="middle" align="left" style="background:#fff;padding:18px">
                <p style="color:#333;">{{ strip_tags(file_get_contents(storage_path('app/public/'.$request->link))) }}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>