<div id="modal-error" class="modal" onclick="this.style.display = 'none'">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modal-error-title"></h2>
        </div>
        <div class="modal-body">
            <div>
                <span id="modal-text">
                    <table>
                    <?php
                    if(isset($_SESSION['error'])){
                    $err = $_SESSION['error'];
                    unset($_SESSION['error']);
                    foreach($err as $e) {
                        if(!empty($e)){echo  "<tr> <td>#</td><td>".explode(':',$e)[0] ."</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;". explode(':',$e)[1] . "</td></tr>";}
                        }
                    }
                    ?>
                    </table>
                </span>
            </div>
        </div>
        <div class="modal-footer clearfix">
            <h3 id="modal-error-desc"></h3>
        </div>
    </div>
</div>
<style>
div.modal {display: none;position: fixed;z-index: 100;padding-top: 1%;left: 0;top: 0;width: 100%;height: 100%;overflow: auto;background-color: rgb(0,0,0);background-color: rgba(190,0,0,0.6);}
/* Modal Content */
div.modal-content {position: relative;background-color: #0009;color: #fff;margin: auto;padding: 0;border: 1px solid #f00;width: 80%;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);-webkit-animation-name: portal;-webkit-animation-duration: 0.7s;animation-name: portal;animation-duration: 0.7s}
/* Add Animation */
@-webkit-keyframes animatetop {from {top:-300px; opacity:0}   to {top:0; opacity:1}}
@keyframes animatetop { from {top:-300px; opacity:0} to {top:0; opacity:1}}

@-webkit-keyframes portal {from {width: 100%;opacity:0}   to {width: 80%;opacity:1}}
@keyframes portal { from {width: 100%;opacity:0} to {width: 80%;opacity:1}}
/* The Close Button */
span.close {color: #000;float: right;font-size: 28px;font-weight: bold;}
span.close:hover,.close:focus {border-color: #fff;text-decoration: none;cursor: pointer;}
span.quit{font-size:12pt;font-family:sans-serif;border: 1px solid #000;padding: 5px;border-radius:5px;font-weight:100}
div.modal-header,div.modal-footer {padding: 2px 16px;/*background-color: #ddd;*/color: rgb(255,120,90);font-weight: 100}
div.modal-body {padding: 2px 16px;overflow-y:auto}
div.modal-body table td:nth-child(2){font-weight: 700}
#modal-text{white-space: pre-line}
#modal-text a{color: #fff}
</style>
<script>
function reportError(title,text,footnote)
{
    var modal = document.getElementById('modal-error');
    modal.style.display = "block";
    document.getElementById("modal-error-title").innerHTML = title;
    document.getElementById("modal-error-desc").innerHTML = footnote;
    if(text !== null)document.getElementById("modal-text").innerHTML = text;
}
</script>