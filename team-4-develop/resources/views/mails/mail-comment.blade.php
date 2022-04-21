<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#4cbd9b" align="center" border="0">
        <tbody>
            <tr>
                <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:28px 15px">
                    <div class="m_-1514011597316807246mj-column-per-100" style="vertical-align:top;display:inline-block;
                            direction:ltr;font-size:13px;text-align:left;width:100%">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px" align="center">
                                            <div style="color:#fff;font-family:'Open Sans',Helvetica,'Hiragino Kaku Gothic ProN',Meiryo,Arial,sans-serif;font-size:24px;font-weight:600;
                                            line-height:36px;text-align:center">
                                                <div class="m_-1514011597316807246contents-section-block" style="padding-right:25px;padding-left:25px">
                                                    Request Comment
                                                    <p style="font-size:21px;font-weight:400;margin-top:3px;margin-bottom:0;text-align: center">{{ $data['time'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    <h3 style="text-align: center"> {{ $data['type'] }} </h3>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;width:100%;
                                font-size:16px;line-height:22px;color:#4a4a4a;border-bottom:solid 1px #eee">
        <tbody>
    
        
        
        <tr>
            <th style="width:25%;font-weight:400;vertical-align:top;border-top:solid 1px #eee;
                            border-left:solid 1px #eee;padding-top:12px;padding-left:20px;padding-right:15px;
                            padding-bottom:12px" valign="top">
                <a href="{{ route('request_detail') . '/' . $data['id'] }}" style="color:#4cbd9b;
                            text-decoration:none" target="_blank" >{{ $data['task'] }}</a>
            </th>
            <td style="font-weight:400;border-top:solid 1px #eee;border-left:solid 1px #eee;
                            border-right:solid 1px #eee;padding-top:4px;padding-left:15px;
                            padding-right:20px;padding-bottom:4px">
                <p style="margin-top:8px;margin-bottom:6px">{{ $data['task'] }}</p>
                <p style="margin-top:8px;margin-bottom:6px">
                    <span style="white-space:nowrap">{{ $data['user'] }} : {!! $data['content'] !!}</span> 
                </p>
            </td>
        </tr>
    
        </tbody>
    </table>
</body>
</html>