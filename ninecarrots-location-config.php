<div id="ninecarrots_wrap">
  <a id="ninecarrots_logo" target="_blank" href="http://9carrots.org" title="go to the main 9carrots site for administration and to learn more"><img src="<?=WP_PLUGIN_URL?>/ninecarrots/ninecarrots_grayscale.png" /></a>
  <h2><?php _e('NineCarrots Configuration'); ?></h2>
  <p>
        The 9carrots local business map system shows businesses that are registered through 9carrots.org.
        They must all have a registered community objective that attracts more customers and have
        signed a contract detailing their commitments to their local community's aims and ideals.
        These agreements tie community and local business together to act as one.
  </p>
  <ul id="actions">
        <li><a target="_blank" href="http://9carrots.org/business/account/register" title="a new business marker for your map that the community can support">register a business</a> on your map.</li>
        <li><a target="_blank" href="http://9carrots.org/envgroup/account/register" title="this is your main group and sets the centre of this map">register your community group</a> on your map.</li>
        <li><a target="_blank" href="http://9carrots.org/contactus" title="contact us">contact us</a> to add new types of things to this map like your other sorts of projects (always free).</li>
  </ul>      

  <form method="post"><div class="form_inline">
      <h3>path to map page on your website</h3>
      <input id="form_path" name="form_path" value="<?=$map_path?>" />
      <p>
          You need to 
          <a target="_blank" title="add a normal post so you can put a link to this map page on your site" href="/wp-admin/post-new.php">add a new blog post</a> 
          in your site linking to this map page so that visitors can find it.<br />
          Open your <a title="go to the page on your site that currently shows the map" target="_blank" href="<?=$map_path?>">current map page at <?=$map_path?></a>.
      </p>


      <h3>default map location centre</h3>
      <p>
          The location and zoom level that the map initially shows to visitors.
          This will usually be your local community.
      </p>
      <ul id="location_options">
          <li>
              <input type="radio" name="form_location_type" id="form_location_type_W" value="W" <?=get_option('ninecarrots_location_type', 'W') == 'W' ? 'checked="1"' : '' ?> />
              <label for="form_location_type_W">default to world view</label>
          </li>
          <li>
              <input type="radio" name="form_location_type" id="form_location_type_G" value="G" <?=get_option('ninecarrots_location_type') == 'G' ? 'checked="1"' : '' ?> />
              <label for="form_location_type_G">select your 9carrots.org local community group</label>
              <select class="large_input" name="form_local_group">
                  <option value="">select local community group</option>
                  <?=$localgroup_list?>
              </select>
              <div class="form_location_type_desc">
                  You need to go to 9carrots.org to 
                  <a title="register your group on 9carrots.org so that you can reference it here" target="_blank" href="http://9carrots.org/envgroup/account/register">create your local community group</a> for this option.
              </div>
          </li>
          <li>
              <input type="radio" name="form_location_type" id="form_location_type_L" value="L" <?=get_option('ninecarrots_location_type') == 'L' ? 'checked="1"' : '' ?>/>
              <label for="form_location_type_L">or specify your location directly</label>
              <input class="large_input" name="form_location" value="<?=get_option('ninecarrots_location')?>" />
              and zoom
              <select name="form_zoom">
                  <option <?=get_option('ninecarrots_zoom') == '15' ? 'selected="1"' : '' ?> value="15">max</option>
                  <option <?=get_option('ninecarrots_zoom') == '14' ? 'selected="1"' : '' ?>>14</option>
                  <option <?=get_option('ninecarrots_zoom') == '13' ? 'selected="1"' : '' ?>>13</option>
                  <option <?=get_option('ninecarrots_zoom') == '12' ? 'selected="1"' : '' ?>>12</option>
                  <option <?=get_option('ninecarrots_zoom') == '11' ? 'selected="1"' : '' ?>>11</option>
                  <option <?=get_option('ninecarrots_zoom') == '10' ? 'selected="1"' : '' ?> value="10">min</option>
              </select>
              <div class="form_location_type_desc">
                  For example: <i>Bedford, UK</i> or <i>MK40 3UE</i> or <i>Milwaukee, Wisconsin, USA</i><br />
                  <i>Postcode (ZIP code), Country</i> is best
              </div>
          </li>
      </ul>

      <div class="hide">
        <h3>display options</h3>
        <ul>
            <li><input type="radio" id="form_display_options_F" name="form_display_options" value="F" <?=get_option('ninecarrots_display_options', 'F') == 'F' ? 'checked="1"' : '' ?> /> <label for="form_display_options_F">full page: no headers, the map takes up the full web page</label></li>
            <li class="disabled"><input disabled="1" type="radio" id="form_display_options_P" name="form_display_options" value="P" <?=get_option('ninecarrots_display_options') == 'P' ? 'checked="1"' : '' ?> /> <label for="form_display_options_P">as a post: depending on your <a target="_blank" title="view free themes" href="http://wordpress.org/extend/themes/">WordPress theme</a> this may cause the map space to be too small</label></li>
        </ul>
      </div>
      
      <p id="disclaimer">
          By activating and using this plugin your are explicitly agreeing to host the 9carrots map on your website 
          and understand that the business, events and any other objects that you register on the map
          will be stored centrally by 9carrots not-for-profit.
          Data is stored centrally for the sole purpose of sharing your ideas and ways of encouraging positive local community engagement
          around the ethical issues of our day.<br/>
        
          <input type="checkbox" id="form_display_poweredby" name="form_display_poweredby" <?=get_option('ninecarrots_display_poweredby') == 'on' ? 'checked="1"' : '' ?> />
          <label for="form_display_poweredby">show the powered by 9carrots link on the map so others can benefit from the tools</label>
      </p>
        
      <input type="submit" name="submit" value="save" />
  </div></form>
</div>