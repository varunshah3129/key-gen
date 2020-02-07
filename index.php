<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div>
<h1>Connection box <span>mask/unmask on demand input</span></h1>
<form>
<!--    <p>-->
<!--        <label for="username">Your login</label>-->
<!--        <input type="text" value="" placeholder="Enter Username" id="username">-->
<!--    </p>-->
    <p >
        <label for="password">Your password</label>
        <input type="password" value="ajax" placeholder="Enter Password" id="password" class="password">

        <button class="unmask" id="unmasking" type="button" title="Mask/Unmask password to check content"><i class="fa fa-eye"></i></button>

                <button id="copy"class = "copyPaste"  type="button">
                    <span class="tooltiptext" id="myTooltip"><i class="fa fa-copy"></i></span>

                </button>

        <button id="refreshToken"class = "refresh"  type="button">
            <span ><i class="fa fa-refresh"></i></span>

        </button>


    </p>
</form>
</div>
<style>
    body {
        background-color: #f6f6f6;
        font-family: "Open Sans", Arial, Helvetica;
        margin-top: 50px;
        font-size: 14px;
    }
    div {
        width: 400px;
        margin: 0 auto;
        text-align: center;
    }
    h1 {
        margin-bottom: 1.5em;
        font-size: 30px;
        color: #484548;
        font-weight: 100;
    }
    h1 span {
        display:block;
        font-size: 14px;
        color: #989598;
    }
    form p { position: relative; }
    label {
        position: absolute;
        left:-9999px;
        text-indent: -9999px;
    }
    input {
        width: 100%;
        padding: 15px 12px;
        margin-bottom: 5px;
        border: 1px solid #e5e5e5;
        border-bottom: 2px solid #ddd;
        background: #f2f2f2;
        color: #555;
    }
    .password + .unmask  {

        position: absolute;
        right: 74px;
        top: 12px;

        width: 25px;
        height: 25px;
        /*background: #aaa;*/
        background: #f2f2f2;
        /*border-radius: 50%;*/
        cursor:pointer;
        border: none;
        -webkit-appearance:none;
    }

    .copyPaste  {

        position: absolute;
        right: 95px;
        top: 12px;

        width: 25px;
        height: 25px;
        /*background: #aaa;*/
        background: #f2f2f2;
        /*border-radius: 50%;*/
        cursor:pointer;
        border: none;
        -webkit-appearance:none;
    }

    .refresh{
        position: absolute;
        right: 55px;
        top: 12px;

        width: 25px;
        height: 25px;
        /*background: #aaa;*/
        background: #f2f2f2;
        /*border-radius: 50%;*/
        cursor:pointer;
        border: none;
        -webkit-appearance:none;
    }

    .password + .unmask:before {

        position:absolute;
        top:4px; left:4px;
        width: 17px;
        height: 17px;
        /*background: #e3e3e3;*/
        z-index:1;
        /*border-radius: 50%;*/
    }
    .password[type="text"] + .unmask:after {

        position:absolute;
        top:6px; left:6px;
        width: 13px;
        height: 13px;
        /*background: #aaa;*/
        z-index:2;
        /*border-radius: 50%;*/
    }



</style>
<script>
    /*
  Switch actions
*/

    function createKey(){
        $.ajax({url: "createKey.php", success: function(result){
                newKey = result;
                document.getElementById('password').value = newKey;


            }});
    }
    window.onload = createKey();



    $('#unmasking').on('click', function(){

        if($(this).prev('input').attr('type') == 'password')
            changeType($(this).prev('input'), 'text');


        else
            changeType($(this).prev('input'), 'password');

        return false;
    });


    /*
      function from : https://gist.github.com/3559343
      Thank you bminer!
    */

    function changeType(x, type) {
        if(x.prop('type') == type)
            return x; //That was easy.
        try {
            return x.prop('type', type);
        } catch(e) {

            var html = $("<div>").append(x.clone()).html();
            var regex = /type=(\")?([^\"\s]+)(\")?/; //matches type=text or type="text"
            var tmp = $(html.match(regex) == null ?
                html.replace(">", ' type="' + type + '">') :
                html.replace(regex, 'type="' + type + '"') );
            //Copy data from old element
            tmp.data('type', x.data('type') );
            var events = x.data('events');
            var cb = function(events) {
                return function() {

                    for(i in events)
                    {
                        var y = events[i];
                        for(j in y)
                            tmp.bind(i, y[j].handler);
                    }
                }
            }(events);
            x.replaceWith(tmp);
            setTimeout(cb, 10); 
            return tmp;
        }
    }

    //copy-function
    document.querySelector("#copy").onclick = function() {
        // Select the content
        document.querySelector("#password").select();
        // Copy to the clipboard
        document.execCommand('copy');
    };

    //refresh token

    $( '#refreshToken' ).on('click',function()
    {
        createKey();
        $('#password').val(newKey);


    });

</script>