<table cellspacing="0" cellpadding="0" border="0" style="color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica">
  <tbody>
    <tr width="100%">
      <td valign="top" align="left" style="background:#eef0f1;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica">
        <table style="border:none;padding:0 18px;margin:50px auto;width:500px">
          <tbody>
            <tr width="100%" height="60">
              <td valign="top" align="left" style="border-top-left-radius:4px;border-top-right-radius:4px;background:#27709b url(https://ci5.googleusercontent.com/proxy/EX6LlCnBPhQ65bTTC5U1NL6rTNHBCnZ9p-zGZG5JBvcmB5SubDn_4qMuoJ-shd76zpYkmhtdzDgcSArG=s0-d-e1-ft#https://trello.com/images/gradient.png) bottom left repeat-x;padding:10px 18px;text-align:center">
                <img height="40" width="40" src="https://csmonline.net/assets/img/logo.png" title="Inaya" style="font-weight:bold;font-size:18px;color:#fff;vertical-align:top" class="CToWUd">
              </td>
            </tr>
            <tr width="100%">
              <td valign="top" align="left" style="background:#fff;padding:18px">
                <h1 style="font-size:20px;margin:16px 0;color:#333;text-align:center"> New Employee Added </h1>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Employee ID:  {{ $user->empid }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Name:  {{ $user->getFullEnglishNameAttribute }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Gender: {{ $user->gender->gender_en }} </p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Nationality:  {{ $user->nationality->country_en }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Department:  {{ $user->section->section_en }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Basic:  {{ $user->basic($user->id) }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Housing:  {{ $user->housing($user->id) }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Transportation:  {{ $user->transportation($user->id) }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Food:  {{ $user->food($user->id) }}</p>
                <p style="font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;">Package: {{ $user->latestSalary($user->id) }} </p>
                <div style="background:#f6f7f8;border-radius:3px"> <br>
                  {{-- <p style="text-align:center"> <a href="#" style="color:#306f9c;font:26px/1.25em 'Helvetica Neue',Arial,Helvetica;text-decoration:none;font-weight:bold" target="_blank">Maodou.io</a> </p> --}}
                  <br><br>
                </div>
                {{-- <p style="font:14px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333"> <strong>What's Trello?</strong> It's the easiest way to organize anything, like having virtual whiteboards with superpowers. <a href="http://trello.com" style="color:#306f9c;text-decoration:none;font-weight:bold" target="_blank">Learn more »</a> </p> --}}
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>