<?php
/*
Plugin Name: eZanga Contextual
Plugin URI: http://wordpress.org/extend/plugins/ezanga/ezanga-contextual/
Description: This is a plugin will automatically add eZanga Contextual scripts to websites.
Author: eZanga.com, Inc.
Version: 1.0
Author URI: http://www.eZanga.com/
*/

### DEFINE CONTANTS ###
//set debuging to false when you go live
define( "WP_DEBUG", false );
define( "EZANGA_CONTEXTUAL_VERSION", "1.0" );
define( "PATH", plugins_url( '',__FILE__ ) );

//tell the functions where to place the output on site and page
add_action( "admin_head", "contextual_css" );
add_action( 'widgets_init', 'contextual_widget_init' );
add_action( "admin_head", "ezanga_admin_script_insert" );

// register widget
function contextual_widget_init(){
	register_widget( 'contextual_widget' );
}

class contextual_widget extends WP_Widget {

	function __construct() {
		parent::WP_Widget( false, $name = __( "eZanga Contextual", "contextual_widget" ) );
        //self::$instanceCount = 0;
	}
    
	function form( $instance ) {
	   // outputs the options form on admin Appearance->Widgets
       $contextual_title     = !empty( $instance["contextual_title"] )     ? $instance["contextual_title"]     : __( "", "eZanga_Contexual" );
       $contextual_token     = !empty( $instance["contextual_token"] )     ? $instance["contextual_token"]     : __( "", "eZanga_Contexual" );
       $contextual_unit      = !empty( $instance["contextual_unit"] )      ? $instance["contextual_unit"]      : __( "cau-160x600", "eZanga_Contexual" );
       $contextual_palette   = !empty( $instance["contextual_palette"] )   ? $instance["contextual_palette"]   : __( "Default", "eZanga_Contexual" );
       $contextual_bg        = !empty( $instance["contextual_bg"] )        ? $instance["contextual_bg"]        : __( "F3F3F3", "eZanga_Contexual" );
       $contextual_link      = !empty( $instance["contextual_link"] )      ? $instance["contextual_link"]      : __( "6EAD21", "eZanga_Contexual" );
       $contextual_url       = !empty( $instance["contextual_url"] )       ? $instance["contextual_url"]       : __( "0000FF", "eZanga_Contexual" );
       $contextual_text      = !empty( $instance["contextual_text"] )      ? $instance["contextual_text"]      : __( "000000", "eZanga_Contexual" );
       $contextual_border    = !empty( $instance["contextual_border"] )    ? $instance["contextual_border"]    : __( "CCCCCC", "eZanga_Contexual" );
       $contextual_no_border = !empty( $instance["contextual_no_border"] ) ? $instance["contextual_no_border"] : __( "", "eZanga_Contexual" );

?>

<div id="contextual_form">
    <div>
        <label for="<?php echo $this->get_field_id( "contextual_title" ); ?>">Title:</label>
        <div class="help-btn">
            <p class="help-box">The title is not required, it is for reference purposes only.</p>
        </div> 
        <input type="text"  value="<?php echo esc_attr( $contextual_title ) ?>" id="<?php echo $this->get_field_id( "contextual_title" ); ?>" class="widefat" name="<?php echo $this->get_field_name( "contextual_title" ); ?>" placeholder="Enter the title here">
    </div>
    <div>
        <label for="<?php echo $this->get_field_id( "contextual_token" ); ?>">Token:</label>
        <div class="help-btn">
            <p class="help-box">The token is used to identify your account.<br />If you do not know what your token is call your eZanga sales rep at <strong>888-439-2642</strong> or login to <a target="_blank" href="https://trafficadvisors.ezanga.com/">Traffic Advisors</a> to get it.</p>
        </div>
        <input type="text"  value="<?php echo esc_attr( $contextual_token ); ?>" id="<?php echo $this->get_field_id( "contextual_token" ) ?>"  class="widefat input-token" name="<?php echo $this->get_field_name( "contextual_token" ); ?>">
        <p class="token-msg" style="display:<?php echo validateContextualToken(  esc_attr( $contextual_token ) ) ? "none" : "block";  ?>">Not a valid token.</p>
    </div>
    <div>
        <label for="<?php echo $this->get_field_id( "contextual_unit" ); ?>">Format</label>
        <div class="help-btn">
            <p class="help-box">The format determins the <strong>Width x Height</strong> in <strong>Pixels</strong>, that advertisements will display on your page.</p>
        </div>
        <select name="<?php echo $this->get_field_name( "contextual_unit" ); ?>" id="<?php echo $this->get_field_id( "contextual_unit" ); ?>">
            <option value="cau-160x600" <?php echo esc_attr( $contextual_unit ) == "cau-160x600" ? "selected=\"selected\"" : ""; ?>>160 x 600 Wide Skyscraper</option>
            <option value="cau-120x600" <?php echo esc_attr( $contextual_unit ) == "cau-120x600" ? "selected=\"selected\"" : ""; ?>>120 x 600 Skyscraper</option>
            <option value="cau-200x200" <?php echo esc_attr( $contextual_unit ) == "cau-200x200" ? "selected=\"selected\"" : ""; ?>>200 x 200 Small Square</option>
            <option value="cau-300x250" <?php echo esc_attr( $contextual_unit ) == "cau-300x250" ? "selected=\"selected\"" : ""; ?>>300 x 250 Medium Rectangle</option>
            <option value="cau-468x60" <?php echo esc_attr( $contextual_unit ) == "cau-468x60" ? "selected=\"selected\"" : ""; ?>>468 x 60 Banner</option>
            <option value="cau-728x90" <?php echo esc_attr( $contextual_unit ) == "cau-728x90" ? "selected=\"selected\"" : ""; ?>>728 x 90 Leaderboard</option>
        </select>
    </div>
    <p>Choose from one of our pre-designed color palettes or design your own custom style. Use web colors only: <a target="_blank" href="http://en.wikipedia.org/wiki/Web_colors">Examples</a></p>
    <label for="<?php echo $this->get_field_id( "contextual_palette" ); ?>">Palette:</label>
    <select name="<?php echo $this->get_field_name( 'contextual_palette' ); ?>" id="<?php echo $this->get_field_id( 'contextual_palette' ); ?>" class="contexual_palette_select">
        <?php echo palette_color_options( esc_attr( $contextual_palette ) ); ?>
    </select>
    <div class="help-btn">
        <p class="help-box">The title is not required, it is for reference purposes only.</p>
    </div> 
    <div class="palette">
        <div class="color-display" id="contextual_bg_color" style="background-color:#<?php echo esc_attr( $contextual_bg ); ?>"></div>   
        <input type="text"  value="<?php echo esc_attr( $contextual_bg ); ?>" maxlength="6" class="input-color contextual_bg" part="bg" id="<?php echo $this->get_field_id( 'contextual_bg' ); ?>" name="<?php echo $this->get_field_name( 'contextual_bg' ); ?>">
        <label for="<?php echo $this->get_field_id( "contextual_bg" ); ?>">Background: <strong>&nbsp;#</strong></label>
        <p class="error_msg">Not a valid web color.</p>
    </div>   
    <div class="palette">
        <div class="color-display" id="contextual_link_color" style="background-color:#<?php echo esc_attr( $contextual_link ); ?>"></div>
        <input type="text"  value="<?php echo esc_attr( $contextual_link ); ?>" maxlength="6" class="input-color contextual_link" part="link" id="<?php echo $this->get_field_id( 'contextual_link' ); ?>" name="<?php echo $this->get_field_name( 'contextual_link' ); ?>">
        <label for="<?php echo $this->get_field_id( "contextual_link" ); ?>">Title: <strong>&nbsp;#</strong></label>
        <p class="error_msg">Not a valid web color.</p>
    </div>
    <div class="palette">
        <div class="color-display" id="contextual_url_color" style="background-color:#<?php echo esc_attr( $contextual_url ); ?>"></div>
        <input type="text"  value="<?php echo esc_attr( $contextual_url ); ?>" maxlength="6" class="input-color contextual_url" part="url" id="<?php echo $this->get_field_id( 'contextual_url' ); ?>" name="<?php echo $this->get_field_name( 'contextual_url' ); ?>">
        <label for="<?php echo $this->get_field_id( "contextual_url" ); ?>">Image URL: <strong>&nbsp;#</strong></label>
        <p class="error_msg">Not a valid web color.</p>
    </div>
    <div class="palette">
        <div class="color-display" id="contextual_text_color" style="background-color:#<?php echo esc_attr( $contextual_text ); ?>"></div>
        <input type="text"  value="<?php echo esc_attr( $contextual_text ); ?>" maxlength="6" class="input-color contextual_text" part="text" id="<?php echo $this->get_field_id( 'contextual_text' ); ?>" name="<?php echo $this->get_field_name( 'contextual_text' ); ?>">
        <label for="<?php echo $this->get_field_id( "contextual_text" ); ?>">Text: <strong>&nbsp;#</strong></label>
        <p class="error_msg">Not a valid web color.</p>
    </div>
    <div class="palette">
        <div class="color-display border-color" id="contextual_border_color" style="background-color:#<?php echo esc_attr( $contextual_border ); ?>"></div>
        <input type="text"  value="<?php echo esc_attr( $contextual_border ); ?>" maxlength="6" class="input-color border-color contextual_border" part="border-color" id="<?php echo $this->get_field_id( 'contextual_border' ); ?>" name="<?php echo $this->get_field_name( 'contextual_border' ); ?>">
        <label for="<?php echo $this->get_field_id( "contextual_border" ); ?>" class="border-color">Border: <strong>&nbsp;#</strong></label>
        <p class="error_msg border-color invisible">Not a valid web color.</p>
        <input type="checkbox" class="checkbox-border clear-both" value="1" <?php echo $contextual_no_border == "1" ? "checked=\"checked\"" : ""; ?> id="<?php echo $this->get_field_id( 'contextual_no_border' ); ?>" name="<?php echo $this->get_field_name( 'contextual_no_border' ); ?>">
        <label for="<?php echo $this->get_field_id( 'contextual_no_border' ); ?>">No Border&nbsp;&nbsp;&nbsp;</label>
    </div>
    <div class="container-btn light on" name="light">Light Background</div>
    <div class="container-btn dark" name="dark">Dark Background</div>
    <div class="ad-unit-container">
        <div class="ad-unit" style="background-color:#<?php echo esc_attr( $contextual_bg ); ?>;border-color:#<?php echo esc_attr( $contextual_border ); ?>;border-width:<?php echo esc_attr( $contextual_no_border ) == "1" ? "0" : "1px";?>">
            <h4><a href="javascript:return(false);" style="color:#<?php echo esc_attr( $contextual_link ); ?>">eZanga Contextual Advertising</a></h4>
            <p class="text" style="color:#<?php echo esc_attr( $contextual_text ); ?>">Target and refine your audience to reach the right customers searching for your products or service with eZanga Contextual.</p>
            <p class="url" style="color:#<?php echo esc_attr( $contextual_url ); ?>">advertising.ezanga.com</p>
            <h4><a href="javascript:return(false);" style="color:#<?php echo esc_attr( $contextual_link ); ?>">eZanga AdPad</a></h4>
            <p class="text" style="color:#<?php echo esc_attr( $contextual_text ); ?>">Drive traffic to your site.</p>
            <p class="url" style="color:#<?php echo esc_attr( $contextual_url ); ?>">adpad.ezanga.com</p>
            <a href="javascript:return(false);" class="ezanga">Ads by <strong>eZanga</strong></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        newWidgetFunctions(); 
        //this checks if the no border checkbox is checked and hides the border input
        var noBorder = $("#<?php echo $this->get_field_id( 'contextual_no_border' ); ?>");
        noBorder.is(':checked') ? noBorder.siblings('.border-color').hide() : noBorder.siblings('.border-color').not('.invisible').show();  
    });
</script>

<?php
	}

	function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = $old_instance;
		$instance["contextual_title"]     = stripslashes( $new_instance["contextual_title"] );
        $instance["contextual_token"]     = stripslashes( $new_instance["contextual_token"] );
        $instance["contextual_unit"]      = stripslashes( $new_instance["contextual_unit"] );
        $instance["contextual_palette"]   = stripslashes( $new_instance["contextual_palette"] );
        $instance["contextual_bg"]        = stripslashes( $new_instance["contextual_bg"] );
        $instance["contextual_link"]      = stripslashes( $new_instance["contextual_link"] );
        $instance["contextual_url"]       = stripslashes( $new_instance["contextual_url"] );
        $instance["contextual_text"]      = stripslashes( $new_instance["contextual_text"] );
        $instance["contextual_border"]    = $new_instance["contextual_no_border"] ? "" : stripslashes( $new_instance["contextual_border"] );
        $instance["contextual_no_border"] = $new_instance["contextual_no_border"];
		return $instance;
	}

	function widget( $args, $instance ) {
		// outputs the content of the widget
        $contextual_token     = $instance['contextual_token'];
        $contextual_unit      = $instance['contextual_unit'];
        $contextual_bg        = $instance['contextual_bg'];
        $contextual_link      = $instance['contextual_link'];
        $contextual_url       = $instance['contextual_url'];
        $contextual_text      = $instance['contextual_text'];
        $contextual_border    = $instance['contextual_no_border'] ? "none" : $instance['contextual_border'];
        $contextual_no_border = $instance['contextual_no_border'];
        if ( $contextual_token != "" ){
?>
            <!-- eZanga Contextual v.<?php echo EZANGA_CONTEXTUAL_VERSION ?> START -->
            <script type="text/javascript">
            	var ezcau_token  = '<?php echo $contextual_token ?>';
                var ezcau_unit   = '<?php echo $contextual_unit ?>';
                var ezcau_bg     = '<?php echo $contextual_bg ?>';
                var ezcau_link   = '<?php echo $contextual_link ?>';
                var ezcau_url    = '<?php echo $contextual_url ?>';
                var ezcau_text   = '<?php echo $contextual_text ?>';
                var ezcau_border = '<?php echo $contextual_border ?>'; 
            </script>
            <script type="text/javascript" src="http://cdn.ezanga.com/scripts/contextual_advert.js"></script>    
            <!-- eZanga Contextual END -->
<?php
        }   
	}
}

function palette_color_options( $current=null ) {
    // create an array of palette options
    $palettes = Array(
        "Default",
        "Breeze",
        "Chalkboard",
        "Cornflake",
        "Dice",
        "Fire",
        "Flyer",
        "Green Monster",
        "Grimace",
        "Halloween",
        "Italy",
        "Jungle",
        "Malibu",
        "Maroon 5",
        "Orange You Glad",
        "Phoenix",
        "Pumpkin Pie",
        "Smores",
        "Stone",
        "Sunliner",
        "Violet",
        "Wildfire",
        "Custom"
    );
    // create select box options
    $options = Array();
    foreach ( $palettes as $palette ) {
        $name = strtolower( str_replace( " ", "-", $palette ) );
        $selected = $current == $name ? " selected=\"selected\"": null;
        $options[] = "<option value=\"$name\"$selected>$palette</option>";
    }
    return join( "", $options );
}

//output the InText CSS in the wp_header
function contextual_css(){
?>
    <style type="text/css">
    
    /* contexual form */
        #contextual_form{position:relative; clear:both; float:left; width:100%; padding:0 0 10px 0;}
        #contextual_form input{margin:5px 0;}
        #contextual_form label{position:relative;}
        #contextual_form select{width: 100%;}
        #contextual_form > div{position:relative; margin:20px 0;}
        #contextual_form .palette{position:relative; width:100%; float:left; margin:10px 0;}
        #contextual_form .palette label{float:right; width:110px; text-align:right; margin:0; line-height:26px;}
        #contextual_form .palette input[type="text"]{float:right; width:70px; margin:0 5px;}
        #contextual_form .palette input[type="checkbox"]{float:right; margin:5px 76px 5px 0;}
        #contextual_form .palette .color-display{float:right; width:15px; height:25px; border:1px solid #ccc;}
        #contextual_form .palette p{width:auto; display:block; float:right; margin-right:10px; line-height:24px;}
        #contextual_form .palette .sml-txt{line-height:24px;}
        #contextual_form .sml-txt{font-size:12px; color:#666; font-weight:400;}
        #contextual_form .clear-both{clear:both!important;}
        #contextual_form .palette p.error_msg{display:none; width:100%; color:#bb0000; margin:0; font-size:12px; text-align:right;}
        #contextual_form .token-msg{margin:0; color:#bb0000; font-size:12px;}
        #contextual_form .help-btn{display:inline-block; position:absolute; top:0; right:0;width:28px; height:18px; background: url("<?php echo PATH ?>/help_btn.png") no-repeat 10px 0;cursor:pointer;}
        #contextual_form .help-box{position:absolute; top:-10px; right:22px; z-index:1000000; display:none; width:250px; padding: 10px; background-color:rgba(255,255,255,1); font-size:12px; font-weight:100;cursor:auto; -webkit-box-shadow:rgba(0,0,0,0.3) 0 1px 3px; -moz-box-shadow:rgba(0,0,0,0.3) 0 1px 3px; box-shadow:rgba(0,0,0,0.3) 0 1px 3px;}
        #contextual_form .help-box strong{color:#459E00;}
        #contextual_form .help-btn:hover .help-box,
        #contextual_form .help-btn .help-box:hover{display:block;}
        
        @media screen and (max-width:782px){
            
            #contextual_form input[type="text"]{padding:3px 5px;}
            #contextual_form input, 
            #contextual_form textarea {font-size: 14px;}
             
        }
        
        .container-btn{position: relative; top: 1px; float: left;width:auto; height:15px; padding: 5px 5px 6px; margin: 0 5px 0 0!important; border: 1px solid #ccc; font-size: 10px; background-color: #fafafa; cursor: pointer;}
        .container-btn.on{z-index: 1000; padding-bottom: 11px; border-bottom: none; cursor: auto;}
        .container-btn.dark{margin: 0!important;background-color: #222;color: #fff;}
        .ad-unit-container{position: relative;clear: both;float: left; width: calc(100% - 2px); height: 214px; margin-top: 0!important; margin-bottom: 0!important; padding: 20px 0; border: 1px solid #ccc; background-color: #fafafa;}
        .ad-unit-container.light{background-color: #fafafa!important;}
        .ad-unit-container.dark{background-color: #222!important;}
        .ad-unit {position: relative; clear:both; width: 200px; height: 200px; margin: 0 auto; padding: 6px; border-style:solid; border-width:1px; border-color: #cccccc; background-color: #f3f3f3; font-family: Arial,Helvetica; font-size: .7em; color: #000000;}
        .ad-unit h4 {float: left; margin: 1px 10px 0 0; padding: 0; font-size: 12px;}
        .ad-unit h4 a {color: #6ead21;}
        .ad-unit p {margin: 0;padding: 0;}
        .ad-unit p.text {clear: left; padding-top: 2px;}
        .ad-unit p.url {margin-bottom: 7px;font-size: 11px; color: #0000ff; word-wrap: break-word;}
        .ezanga {position: absolute;bottom: 3px;right: 6px; color: #000000; text-decoration: none;}
  
    </style>
<?php 
}

function ezanga_admin_script_insert(){
    
?>
    <!-- eZanga START -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
        function newWidgetFunctions(){
            //validates token while user is typing
            $('.input-token').donetyping(function(){
                var thisToken   = $(this).val();
                var thisMessage = $(this).siblings('.token-msg');
                /^cau-[0-9]{16}$/.test(thisToken) || thisToken == '' ? thisMessage.hide() : thisMessage.show();
            });
            
            $('.input-color').donetyping(function(){
                var inputText      = $(this).val();
                var inputName      = $(this).attr('part');
                var colorDisplay   = $(this).siblings('.color-display');
                var adUnit         = $(this).parents('div').siblings('.ad-unit-container').children(".ad-unit");
                var errorMsg       = $(this).siblings('.error_msg');
                var borderErrorMsg = $(this).siblings('.error_msg.border-color');
                var paletteSelect  = $(this).parents('div').siblings('.contexual_palette_select');
                
                //if a valid web color was entered
                //if (/(^[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(inputText)){
                if (/(^[0-9A-F]{6}$)/i.test(inputText)){   
                    colorDisplay.css('background-color', '#'+inputText);
                    switch(inputName){
                        case "bg":
                            adUnit.css('background-color', '#'+inputText);
                            break;
                        case "link":
                            adUnit.children('h4').children('a').css('color', '#'+inputText);
                            break;
                        case "url":
                            adUnit.children('.url').css('color', '#'+inputText);
                            break;
                        case "text":
                            adUnit.children('.text').css('color', '#'+inputText);
                            break;
                        case "border-color":
                            adUnit.css({
                                'border-color': '#'+inputText,
                                'border-width': '1px'
                            });
                            break;
                    }
                    paletteSelect.val('custom');
                    errorMsg.hide();
                    //handle the border color
                    if (errorMsg.hasClass('border-color') && !borderErrorMsg.hasClass('invisible')){
                        borderErrorMsg.addClass('invisible');
                    }
                } 
                //if a invalid web color was entered
                else {
                    borderErrorMsg.removeClass('invisible');
                    colorDisplay.css('background-color', '#FFFFFF');
                    errorMsg.show();
                }
            });
            
            //prevent double binding
            $('input.checkbox-border').unbind('change');
            //hide the border color input if no-border is selected
            $('input.checkbox-border').change(function(){
                $(this).parents().siblings('.contexual_palette_select').val('custom');
                var inputText = $(this).siblings('input.border-color').val();
                var adUnit = $(this).parents('div').siblings('.ad-unit-container').children(".ad-unit");
                if ($(this).is(':checked')) {
                    $('.border-color').hide();
                    adUnit.css('border-width', 0);
                } else {
                    $('.border-color').not('.invisible').show();
                    adUnit.css({
                        'border-color': '#'+inputText,
                        'border-width': '1px'
                    }); 
                }    
            });
            
            //prevent double binding
            $('.contexual_palette_select').unbind('change');
            //update colors on the color-display and ad-unit when a palette is selected
            $('.contexual_palette_select').change(function(){
        
                //select this forms inputs
                var thisContextualBg      = $(this).siblings('div').children('.contextual_bg');
                var thisContextualLink    = $(this).siblings('div').children('.contextual_link');
                var thisContextualUrl     = $(this).siblings('div').children('.contextual_url');
                var thisContextualText    = $(this).siblings('div').children('.contextual_text');
                var thisContextualBorder  = $(this).siblings('div').children('.contextual_border');
                //select the corisponding color-display 
                var thisContextualBgDisplay      = thisContextualBg.siblings('.color-display');
                var thisContextualLinkDisplay    = thisContextualLink.siblings('.color-display');
                var thisContextualUrlDisplay     = thisContextualUrl.siblings('.color-display');
                var thisContextualTextDisplay    = thisContextualText.siblings('.color-display');
                var thisContextualBorderDisplay  = thisContextualBorder.siblings('.color-display');
                //select the corisponding ad-unit elements
                var thisAdUnit       = $(this).siblings('.ad-unit-container').children(".ad-unit");
                var thisAdUnitLink   = thisAdUnit.children('h4').children('a');
                var thisAdUnitUrl    = thisAdUnit.children('.url');
                var thisAdUnitText   = thisAdUnit.children('.text');
                var thisAdUnitEzanga = thisAdUnit.children('.ezanga');
                
                var palettes = [
                    {name: "default",           colors: {bg:"F3F3F3", li:"518A0B", ur:"0000FF", te:"000000", bo:"CCCCCC"}},
                    {name: "breeze",            colors: {bg:"E2F3E9", li:"AD6D8F", ur:"8F45FF", te:"161819", bo:"47CCBA"}},
                    {name: "chalkboard",        colors: {bg:"2D8C6C", li:"FFFFFF", ur:"000000", te:"FFFFFF", bo:"CCCCCC"}},
                    {name: "cornflake",         colors: {bg:"5097F3", li:"FFEFB0", ur:"FFFFFF", te:"000000", bo:"0000FF"}},
                    {name: "dice",              colors: {bg:"080808", li:"F2F2F2", ur:"FCFFF7", te:"FAFAFA", bo:"FFFFFF"}},
                    {name: "fire",              colors: {bg:"911616", li:"FFFFFF", ur:"FF9538", te:"FFE666", bo:"000000"}},
                    {name: "flyer",             colors: {bg:"1E1E1E", li:"DD3510", ur:"C28B38", te:"FDFDFD", bo:"C28B38"}},
                    {name: "green-monster",     colors: {bg:"DAEDD5", li:"44AD3D", ur:"347028", te:"000000", bo:"CCCCCC"}},
                    {name: "grimace",           colors: {bg:"633656", li:"FFFFFF", ur:"9E5689", te:"000000", bo:"633656"}},
                    {name: "halloween",         colors: {bg:"F58236", li:"000000", ur:"FFF717", te:"000000", bo:"CCCCCC"}},
                    {name: "italy",             colors: {bg:"000000", li:"09D632", ur:"FF143C", te:"FFFFFF", bo:"CCCCCC"}},
                    {name: "jungle",            colors: {bg:"1F1F1F", li:"6EAD21", ur:"FFF6C7", te:"ADAD2D", bo:"56CC1B"}},
                    {name: "malibu",            colors: {bg:"FFB561", li:"CF0A24", ur:"0000D4", te:"04000F", bo:"DE450D"}},
                    {name: "maroon-5",          colors: {bg:"7D070B", li:"F2F207", ur:"8CFBFF", te:"F7F7F7", bo:"030303"}},
                    {name: "orange-you-glad",   colors: {bg:"FA9B0D", li:"EDFC5D", ur:"FAFAFA", te:"0F0F0F", bo:"0D0D0D"}},
                    {name: "phoenix",           colors: {bg:"3F2680", li:"E6601F", ur:"B33438", te:"D78A15", bo:"CCCCCC"}},
                    {name: "pumpkin-pie",       colors: {bg:"C18953", li:"FFFFFF", ur:"FFFFA0", te:"000000", bo:"944D08"}},
                    {name: "smores",            colors: {bg:"B39157", li:"FFFFFF", ur:"6E412B", te:"472A1C", bo:"000000"}},
                    {name: "stone",             colors: {bg:"656656", li:"FFFFFF", ur:"343434", te:"000000", bo:"343434"}},
                    {name: "sunliner",          colors: {bg:"FAFFD1", li:"375711", ur:"80081B", te:"2E2E2E", bo:"CBD179"}},
                    {name: "violet",            colors: {bg:"F3DBED", li:"5028AD", ur:"FF4F95", te:"000000", bo:"FA89AF"}},
                    {name: "wildfire",          colors: {bg:"ACF31D", li:"0000FF", ur:"043808", te:"000000", bo:"043808"}}
                ];
                for (var i = 0; i < palettes.length; i++){
                    if (palettes[i]['name'] == $(this).val()){
                        var thisPalette = palettes[i]['colors'];
                        break;
                    }  
                }
                //update this forms inputs
                thisContextualBg.val(thisPalette['bg']);
                thisContextualLink.val(thisPalette['li']);
                thisContextualUrl.val(thisPalette['ur']);
                thisContextualText.val(thisPalette['te']);
                thisContextualBorder.val(thisPalette['bo']);
                
                //update the corisponding color-display 
                thisContextualBgDisplay.css('background-color', '#'+thisPalette['bg']);
                thisContextualLinkDisplay.css('background-color', '#'+thisPalette['li']);
                thisContextualUrlDisplay.css('background-color', '#'+thisPalette['ur']);
                thisContextualTextDisplay.css('background-color', '#'+thisPalette['te']);
                thisContextualBorderDisplay.css('background-color', '#'+thisPalette['bo']); 
               
                //update the corisponding ad unit
                thisAdUnit.css({
                    'background-color':'#'+thisPalette['bg'],
                    'border-color': '#'+thisPalette['bo'],
                });
                thisAdUnitLink.css('color', '#'+thisPalette['li']);
                thisAdUnitUrl.css('color', '#'+thisPalette['ur']);
                thisAdUnitText.css('color', '#'+thisPalette['te']);
                thisAdUnitEzanga.css('color', '#'+thisPalette['ur']);
                
                //handle border color
                $(this).siblings('.palette').children('.border-color').not('.invisible').show();
                $(this).siblings('.palette').children('.checkbox-border').removeAttr('checked');
            });
            
            //prevent double binding
            $('.container-btn').unbind('click');
            //change background color of .ad-unit-container
            $('.container-btn').click(function(){
                $(this).parents().children('.container-btn').removeClass('on');
                $(this).addClass('on');
                $(this).siblings('.ad-unit-container').removeClass('light, dark');
                $(this).siblings('.ad-unit-container').addClass($(this).attr('name'));
            });
        };

        ;(function($){
            $.fn.extend({
                donetyping: function(callback, timeout){
                    timeout = timeout || 1500; // 1.5 second default timeout
                    maxLength = 6;//6 is the length of a web color
                    var timeoutReference,
                        doneTyping = function(el){
                            if (!timeoutReference) return;
                            timeoutReference = null;
                            callback.call(el);
                        };
                    return this.each(function(i,el){
                        var $el = $(el);
                        //stops the event from binding more than once - this is needed every time a new widget is used/created
                        $el.is(':input') && $el.off('keyup keypress paste');
                        $el.is(':input') && $el.on('keyup keypress paste', function(e){
                            //this will fire the callback when the length of the input = 6
                            var elementValue = $el.val();
                            if (elementValue.length >= maxLength){
                                doneTyping(el);
                            }
                            // This catches the backspace button in chrome, but also prevents the event from triggering too premptively. 
                            // Without this line, using tab/shift+tab will make the focused element fire the callback.
                            if (e.type == 'keyup' && e.keyCode != 8) return;
                            // Check if timeout has been set. If it has, \"reset\" the clock and start over again.
                            if (timeoutReference) clearTimeout(timeoutReference);
                            timeoutReference = setTimeout(function(){
                                // if we made it here, our timeout has elapsed. Fire the callback
                                doneTyping(el);
                            }, timeout);
                        }).on('blur',function(){
                            // If we can, fire the event since we're leaving the field
                            doneTyping(el);
                        });
                    });
                }
            });
        })(jQuery);
    </script>  
    <!-- eZanga END -->
        
<?php  
 
}
//VALIDATION FUNCTION
function validateContextualToken( $token ) {
    if ( $token ) {
        $token = trim($token, " ");
        if ( preg_match( "/^cau-[0-9]{16}$/", $token ) ) {
            return true;
        } else {
            return false;
        }
    } else {
        //will return true if the user has not entered a token yet, gotta give the man a chance.
        return true;
    }
}

?>