<div id="query-pane" class="dark">
    <h3>queries</h3>
    <form method="post" action=".">
        <div><input type="text" placeholder="Firstname Lastname" required /></div>
        <div><input type="email" placeholder="Email Address" required /></div>
        <div><textarea required placeholder="type query here..." style="min-height: 128px"></textarea></div>
        <button class="button_1">Send</button>
        <input type="hidden" name="action" value="query"/>
        <input type="hidden" name="target" value="<?= $action;?>"/>
    </form>
</div>
<style>
     div#query-pane form input,  div#query-pane textarea { width: 100%; padding: 5px 0;border: 0;text-indent: 7pt;background-color: #d5d5d5;color: #000}
     div#query-pane form input::placeholder,  div#query-pane form textArea::placeholder{color: #000}
     div#query-pane form input:hover,  div#query-pane form textArea:hover{background-color: #e9e9e9}
     div#query-pane form div{margin: 0 0 .3em 0}
</style>