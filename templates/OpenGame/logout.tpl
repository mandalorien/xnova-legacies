        <script type="text/javascript">
            var second = {tps_seconds};

            function Init() {
                document.getElementById("CompteARebours").innerHTML = second;
                setInterval(AffichageCompteARebours,1000);
            }

            function AffichageCompteARebours() {
                document.getElementById("CompteARebours").innerHTML = --second;
            }
 
            window.onload = function () { Init(); }
        </script>

        <center>
            <p></p>
            <table width="519">
                <tr>
                    <td class="c"><font color="">{session_close}</font></td>
                </tr>
                <tr>
                    <th class="errormessage">{mes_session_close}</th>
                </tr>
            </table>
            <p></p>
            <table width="519">
                <tr>
                    <td class="c">Redirection</td>
                </tr>
                <tr>
                    <th class="errormessage">Vous serez redirigez dans <span id=CompteARebours></span> s<p></p><a href="login.php">Cliquez ici pour ne pas attendre</a></th>
                </tr>
            </table>
        </center>