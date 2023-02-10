<html lang="tw">
                <script>
                function oAuth2($Acc) {
                    var URL = 'https://notify-bot.line.me/oauth/authorize?';
                    URL += 'response_type=code';
                    URL += '&client_id=fMXr1OhODrBgHbCBQJ96wH';
                    //URL += '&redirect_uri=http://127.0.0.1:8787/bct/';
                    URL += '&redirect_uri=http://35.201.134.104/TSMC-CareerHack2023/CatchLineAccess.php';
                    URL += '&scope=notify';
                    URL += '&state='+$Acc;
                    URL += '&response_mode=form_post';
                    window.location.href = URL;
                }
                oAuth2("BEAR");
            </script>

</html>