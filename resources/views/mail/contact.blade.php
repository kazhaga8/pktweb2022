<html>

<body>
  <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td valign="top" height="10" bgcolor="#ffffff" align="center">
          <table width="840" cellspacing="0" cellpadding="10" border="0">
            <tbody>
              <tr>
                <td valign="top" align="center">
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                    <tbody>

                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#ebebeb" align="center">
          <table width="735" cellspacing="0" cellpadding="0" border="0" style="font-family:tahoma,geneva,sans-serif">
            <tbody>
              <tr>
                <td valign="top" align="center" bgcolor="#ffffff">
                  <table width="100%" cellspacing="0" cellpadding="8" border="0">
                    <tbody>
                      <tr>
                        <td valign="top" bgcolor="#ebebeb" align="left">
                          &nbsp;
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td valign="top" bgcolor="#ffffff" align="center">
                  <table width="100%" cellspacing="0" cellpadding="10" border="0" style="border-bottom: 2px solid #1268b3;">
                    <tbody>
                      <tr>
                        <td valign="middle" align="center" style="width:50%;" colspan="3">
                          <img src="{{ $message->embed($logo) }}" alt="logo" style="height: 50px;text-align:center;">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table width="80%" cellspacing="0" cellpadding="5" border="0" style="margin-top:15px;">
                    <tbody>
                      <tr>
                        <td valign="middle" align="left" style="width:100%;">
                          <span>Berikut ini adalah inkuiri dari website www.pupukkaltim.com:</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table width="80%" cellpadding="5" style="border: 0px solid #b4b8b6;border-collapse: collapse;margin-bottom:10px;">
                    <tbody>
                      <tr>
                        <td width="20%">Subject</td>
                        <td width="5%">:</td>
                        <td width="75%">{{ $subject }}</td>
                      </tr>
                      <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td>{{ $tujuan }}</td>
                      </tr>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $name }}</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $email }}</td>
                      </tr>
                      <tr>
                        <td>No HP</td>
                        <td>:</td>
                        <td>{{ $phone }}</td>
                      </tr>
                      <tr>
                        <td>No KTP</td>
                        <td>:</td>
                        <td>{{ $ktp }}</td>
                      </tr>
                      <tr>
                        <td valign="top">Pesan</td>
                        <td valign="top">:</td>
                        <td>{{ $msg }}</td>
                      </tr>
                      <tr>
                        <td valign="top">File KTP</td>
                        <td valign="top">:</td>
                        <td><img width="200" src="{{ $message->embed($ktp_image) }}"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>

            </tbody>
          </table>
          <table width="735" cellspacing="0" cellpadding="20" border="0" style="background:#1268b3;font-family:tahoma,geneva,sans-serif;margin-top:0;margin-bottom:20px;font-size:12px;color:#fff;">
            <tbody>
              <tr>
                <td valign="middle" align="center">
                  Copyright &copy;2022 PT Pupuk Kalimantan Timur (PKT)
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>
