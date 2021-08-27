<?php
header_remove("X-Powered-By"); 
header('Server: bravytech');

$script_name = strtolower(basename(__FILE__, '.php'));
$dashboard = ($script_name=='dashboard')? '#' : 'dashboard.php';
$settings = ($script_name=='settings')? '#' : 'settings.php';
$password = ($script_name=='password')? '#' : 'password.php';
require_once('page-header.php');
require_once('../core/core.inc.php');
require_once('../core/func.php');


if (!isset($_SESSION['pond_user'])) 
	header('Location: index.php');


$username = $_SESSION['pond_user'];

$sql = "SELECT username 
		FROM $dbname.pool_limit
		WHERE username='$username'";
$count = countRows($sql);
if ($count<1) {
	query("INSERT INTO $dbname.pool_limit
			VALUES ('$username',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'')"); 
}// create table if it doesn't exist
else {
	$sql = "SELECT 
				min_depth, max_depth,
				min_temp, max_temp,
				min_turb, max_turb,
				min_ph, max_ph
			FROM $dbname.pool_limit
			WHERE username='$username'";
	$fetch = getRow($sql);

	$min_depth = $fetch['min_depth'];
	$max_depth = $fetch['max_depth'];
	$min_temp = $fetch['min_temp'];
	$max_temp = $fetch['max_temp'];
	$min_turb = $fetch['min_turb'];
	$max_turb = $fetch['max_turb'];
	$min_ph = $fetch['min_ph'];
	$max_ph = $fetch['max_ph'];
} //get pool_limit if it exists



$sql = "SELECT depth, temp, acidity, turbidity
		FROM $dbname.received
		WHERE username='$username'
		ORDER BY regdate DESC
		LIMIT 1";
$fetch = getRow($sql);

$depth = $fetch['depth'];
$temp =  $fetch['temp'];
$acidity = $fetch['acidity'];
$turbidity = $fetch['turbidity'];



//Pool status
$sql = "SELECT depth, temp, acidity, turbidity, regdate
		FROM $dbname.received
		WHERE username='$username'
		ORDER BY regdate DESC
		LIMIT 1";
$fetch = getRow($sql);

$received_depth = $fetch['depth'];
$received_temp = $fetch['temp'];
$received_ph = $fetch['acidity'];
$received_turb = $fetch['turbidity'];

$received_time = $fetch['regdate'];
$received_time = date('d-M g:ia');

$received_depth_text = "{$received_depth}cm&nbsp;&nbsp;&nbsp;&nbsp;{$received_time}";
$received_temp_text = "{$received_temp}<sup>0</sup>C&nbsp;&nbsp;&nbsp;&nbsp;{$received_time}";
$received_ph_text = "{$received_ph}&nbsp;&nbsp;&nbsp;&nbsp;{$received_time}";
$received_turb_text = "{$received_turb}%&nbsp;&nbsp;&nbsp;&nbsp;{$received_time}";


$depth_color_code = 'bg-success';
$depth_text_code = 'Normal';
if ( $received_depth<$min_depth || $received_depth>$max_depth ) {
	$depth_color_code = 'bg-danger';
	$depth_text_code = 'Abnormal';
}

$temp_color_code = 'bg-success';
$temp_text_code = 'Normal';
if ( $received_temp<$min_temp || $received_temp>$max_temp ) {
	$temp_color_code = 'bg-danger';
	$temp_text_code = 'Abnormal';
}

$ph_color_code = 'bg-success';
$ph_text_code = 'Normal';
if ( $received_ph<$min_ph || $received_ph>$max_ph ) {
	$ph_color_code = 'bg-danger';
	$ph_text_code = 'Abnormal';
}

$turb_color_code = 'bg-success';
$turb_text_code = 'Normal';
if ( $received_turb<$min_turb || $received_turb>$max_turb ) {
	$turb_color_code = 'bg-danger';
	$turb_text_code = 'Abnormal';
}


?>



    <section class="features-icons bg-light text-center mb-4" style="padding-top: 3rem;padding-bottom: 0rem;color: #09152a;">
    	<h5>Update occurs every 10 seconds.</h5>
        <div class="container">
            <div class="row gauge-container" style="padding-bottom:0px;">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div style="background-color: #e6e6e6;">
                        <div class="gauge depth rounded m-4 pt-3 pb-3" style="min-height: 270px;width:auto;"></div>
                        <div style="background-color:#c4c4c7;">
                            <div class="row" style="max-width:300px;margin:5px auto;">
                                <div class="col-12">
                                    <p class="mt-2"><strong>Depth: </strong>
                                    	<span id='depth-span'><?php echo $received_depth_text; ?></span></p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Min: </strong><?php echo $min_depth; ?>cm</p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Max: </strong><?php echo $max_depth; ?>cm</p>
                                </div>
                                <div class="col-12 <?php echo $depth_color_code; ?> text-light" style="padding:3px !important;" id='depth-color-code'>
                                    <p style="margin-bottom:0px;"><strong>Status:</strong> 
                                    	<span id='depth-text-code'><?php echo $depth_text_code; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div style="background-color: #e6e6e6;">
                        <div class="gauge temp rounded m-4 pt-3 pb-3" style="min-height: 270px;width:auto;"></div>
                        <div style="background-color:#c4c4c7;">
                            <div class="row" style="max-width:300px;margin:5px auto;">
                                <div class="col-12">
                                    <p class="mt-2"><strong>Temp.: </strong>
                                    	<span id='temp-span'><?php echo $received_temp_text; ?></span></p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Min: </strong><?php echo $min_temp; ?><sup>0</sup>C</p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Max: </strong><?php echo $max_temp; ?><sup>0</sup>C</p>
                                </div>
                                <div class="col-12 <?php echo $temp_color_code; ?> text-light" style="padding:3px !important;" id='temp-color-code'>
                                    <p style="margin-bottom:0px;"><strong>Status:</strong> 
                                    	<span id='temp-text-code'><?php echo $temp_text_code; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gauge-container" style="padding-top:0px;padding-bottom:0px;">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div style="background-color: #e6e6e6;">
                        <div class="gauge turbidity rounded m-4 pt-3 pb-3" style="min-height: 270px;width:auto;"></div>
                        <div style="background-color:#c4c4c7;">
                            <div class="row" style="max-width:300px;margin:5px auto;">
                                <div class="col-12">
                                    <p class="mt-2"><strong>Turbidity: </strong>
                                    	<span id='turb-span'><?php echo $received_turb_text; ?></span></p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Min: </strong><?php echo $min_turb; ?>%<br></p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Max: </strong><?php echo $max_turb; ?>%</p>
                                </div>
                                <div class="col-12 <?php echo $turb_color_code; ?> text-light" style="padding:3px !important;" id='turb-color-code'>
                                    <p style="margin-bottom:0px;"><strong>Status:</strong> 
                                    	<span id='turb-text-code'><?php echo $turb_text_code; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div style="background-color: #e6e6e6;">
                        <div class="gauge ph rounded m-4 pt-3 pb-3" style="min-height: 270px;width:auto;"></div>
                        <div style="background-color:#c4c4c7;">
                            <div class="row" style="max-width:300px;margin:5px auto;">
                                <div class="col-12">
                                    <p class="mt-2"><strong>PH: </strong>
                                    	<span id='ph-span'><?php echo $received_ph_text; ?></span></p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Min: </strong><?php echo $min_ph; ?><br></p>
                                </div>
                                <div class="col-6">
                                    <p style="margin-bottom:0px;"><strong>Max: </strong><?php echo $max_ph; ?></p>
                                </div>
                                <div class="col-12 <?php echo $ph_color_code; ?> text-light" style="padding:3px !important;" id='ph-color-code'>
                                    <p style="margin-bottom:0px;"><strong>Status:</strong> 
                                    	<span id='ph-text-code'><?php echo $ph_text_code; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><svg width="0" height="0" version="1.1" class="" xmlns="http://www.w3.org/2000/svg">
  <defs>
      <linearGradient id="gradientGauge">
        <stop class="color-red" offset="0%"/>
        <stop class="color-yellow" offset="17%"/>
        <stop class="color-green" offset="40%"/>
        <stop class="color-yellow" offset="87%"/>
        <stop class="color-red" offset="100%"/>
      </linearGradient>
  </defs>  
</svg>
    <footer class="footer bg-light" style="background-color: #e6e6e6 !important; padding-bottom:5px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto h-100 text-center text-lg-left">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="#">About</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">Contact</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">Terms of &nbsp;Use</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">© Intellifarms Pool Manager 2020. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 my-auto h-100 text-center text-lg-right">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook fa-2x fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter fa-2x fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram fa-2x fa-fw"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js?h=83e266cb1712b47c265f77a8f9e18451"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js?h=7c038681746a729e2fff9520a575e78c"></script>
    <script src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <!--script src="assets/js/script.min.js?h=2961b97ba961a9dd9543f9aafd79b4b8"></script-->





<!--METER SCRIPT STARTS-->
<script>

$(function () {
	const depth_span = document.getElementById('depth-span');
	const temp_span = document.getElementById('temp-span');
	const turb_span = document.getElementById('turb-span');
	const ph_span = document.getElementById('ph-span');

	const depthColorCode = document.getElementById('depth-color-code');
	const tempColorCode = document.getElementById('temp-color-code');
	const turbColorCode = document.getElementById('turb-color-code');
	const phColorCode = document.getElementById('ph-color-code');

	const depthTextCode = document.getElementById('depth-text-code');
	const tempTextCode = document.getElementById('temp-text-code');
	const turbTextCode = document.getElementById('turb-text-code');
	const phTextCode = document.getElementById('ph-text-code');



	const min_depth = <?php echo $min_depth; ?>;
	const max_depth = <?php echo $max_depth; ?>;
	const min_temp = <?php echo $min_temp; ?>;
	const max_temp = <?php echo $max_temp; ?>;
	const min_turb = <?php echo $min_turb; ?>;
	const max_turb = <?php echo $max_turb; ?>;
	const min_ph = <?php echo $min_ph; ?>;
	const max_ph = <?php echo $max_ph; ?>;



  //Temperature class
  class TempChart {
    constructor(element, params) {
      this._element = element;
      this._initialValue = params.initialValue;
      this._higherValue = params.higherValue;
      this._title = params.title;
      this._subtitle = params.subtitle;
    }

    _buildConfig() {
      let element = this._element;

      return {
        value: this._initialValue,
        valueIndicator: {
          color: '#fff' },

        geometry: {
          startAngle: 180,
          endAngle: 360 },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: [0,10,20,30,40,50,60],
          tick: {
            length: 8 },

          label: {
            font: {
              color: '#000',
              size: 9,
              family: '"Open Sans", sans-serif' } } },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#09152a',
            size: 10 },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#09152a',
              weight: 700,
              size: 28 } } },



        onInitialized: function () {
          let currentGauge = $(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        } };
    }

    init() {
      $(this._element).dxCircularGauge(this._buildConfig());
  }}
    //temperature class ends




  //Depth class
  class DepthChart {
    constructor(element, params) {
      this._element = element;
      this._initialValue = params.initialValue;
      this._higherValue = params.higherValue;
      this._title = params.title;
      this._subtitle = params.subtitle;
    }

    _buildConfig() {
      let element = this._element;

      return {
        value: this._initialValue,
        valueIndicator: {
          color: '#fff' },

        geometry: {
          startAngle: 180,
          endAngle: 360 },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: [0,50,100,150,200,250,300,350,400,450,500],
          tick: {
            length: 8 },

          label: {
            font: {
              color: '#000',
              size: 9,
              family: '"Open Sans", sans-serif' } } },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#09152a',
            size: 10 },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#09152a',
              weight: 700,
              size: 28 } } },



        onInitialized: function () {
          let currentGauge = $(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        } };
    }

    init() {
      $(this._element).dxCircularGauge(this._buildConfig());
  }}
    //Depth class ends




  //Turbidity class
  class TurbidityChart {
    constructor(element, params) {
      this._element = element;
      this._initialValue = params.initialValue;
      this._higherValue = params.higherValue;
      this._title = params.title;
      this._subtitle = params.subtitle;
    }

    _buildConfig() {
      let element = this._element;

      return {
        value: this._initialValue,
        valueIndicator: {
          color: '#fff' },

        geometry: {
          startAngle: 180,
          endAngle: 360 },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: [0,10,20,30,40,50,60,70,80,90,100],
          tick: {
            length: 8 },

          label: {
            font: {
              color: '#000',
              size: 9,
              family: '"Open Sans", sans-serif' } } },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#09152a',
            size: 10 },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#09152a',
              weight: 700,
              size: 28 } } },



        onInitialized: function () {
          let currentGauge = $(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        } };
    }

    init() {
      $(this._element).dxCircularGauge(this._buildConfig());
  }}
    //Turbidity class ends




  //ph class
  class phChart {
    constructor(element, params) {
      this._element = element;
      this._initialValue = params.initialValue;
      this._higherValue = params.higherValue;
      this._title = params.title;
      this._subtitle = params.subtitle;
    }

    _buildConfig() {
      let element = this._element;

      return {
        value: this._initialValue,
        valueIndicator: {
          color: '#fff' },

        geometry: {
          startAngle: 180,
          endAngle: 360 },

        scale: {
          startValue: 0,
          endValue: this._higherValue,
          customTicks: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
          tick: {
            length: 8 },

          label: {
            font: {
              color: '#000',
              size: 9,
              family: '"Open Sans", sans-serif' } } },



        title: {
          verticalAlignment: 'bottom',
          text: this._title,
          font: {
            family: '"Open Sans", sans-serif',
            color: '#09152a',
            size: 10 },

          subtitle: {
            text: this._subtitle,
            font: {
              family: '"Open Sans", sans-serif',
              color: '#09152a',
              weight: 700,
              size: 28 } } },



        onInitialized: function () {
          let currentGauge = $(element);
          let circle = currentGauge.find('.dxg-spindle-hole').clone();
          let border = currentGauge.find('.dxg-spindle-border').clone();

          currentGauge.find('.dxg-title text').first().attr('y', 48);
          currentGauge.find('.dxg-title text').last().attr('y', 28);
          currentGauge.find('.dxg-value-indicator').append(border, circle);
        } };
    }

    init() {
      $(this._element).dxCircularGauge(this._buildConfig());
  }}
    //ph class ends



  



	////////set parameter wrapper starts
	////////////////////////////////////
	//temperature
  	function temp(value) {
	    $('.temp').each(function (index, item) {
	      let params = {
	        initialValue: value,
	        higherValue: 60,
	        title: 'Temperature',
	        subtitle: value+'ºC' };

	      let gauge = new TempChart(item, params);
	      gauge.init();
	    });
	}

    //water depth
    function depth(value) {
	    $('.depth').each(function (index, item) {
	      let params = {
	        initialValue: value,
	        higherValue: 500,
	        title: 'Depth',
	        subtitle: value+'CM' };

	      let gauge = new DepthChart(item, params);
	      gauge.init();
	    });
	}

	//Turbidity depth
    function turbidity(value) {
	    $('.turbidity').each(function (index, item) {
	      let params = {
	        initialValue: value,
	        higherValue: 100,
	        title: 'Turbidity',
	        subtitle: value+'%' };

	      let gauge = new TurbidityChart(item, params);
	      gauge.init();
	    });
	}

    //water ph
    function ph(value) {
	    $('.ph').each(function (index, item) {
	      let params = {
	        initialValue: value,
	        higherValue: 14,
	        title: 'PH',
	        subtitle: value };

	      let gauge = new phChart(item, params);
	      gauge.init();
	    });
	}
	////////////////////////////////////
	////////set parameter wrapper ends





  //document ready  
  $(document).ready(function () {
	temp(<?php echo $temp; ?>);
	depth(<?php echo $depth; ?>);
	turbidity(<?php echo $turbidity; ?>);
	ph(<?php echo $acidity; ?>);

  });
    
    




	function ajaxObj(){
		if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
	}


	//update page data
	function updateData(){
		ajaxObj();
		xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
	            loadUpdate(xmlhttp.responseText);
	    };
	    xmlhttp.open("get","script.php", true);
	    xmlhttp.send();	
	}

	function loadUpdate(response) {
		if (response=='')
			return;

		response = response.split(';');
		regtime = response[4];

		depth( response[0] );
		temp( response[1] );
		ph( response[2] );
		turbidity( response[3] );

		depth_span.innerHTML = response[0]+"cm&nbsp;&nbsp;&nbsp;&nbsp;"+regtime;
		temp_span.innerHTML = response[1]+"<sup>0</sup>C&nbsp;&nbsp;&nbsp;&nbsp;"+regtime;
		ph_span.innerHTML = response[2]+"&nbsp;&nbsp;&nbsp;&nbsp;"+regtime;
		turb_span.innerHTML = response[3]+"%&nbsp;&nbsp;&nbsp;&nbsp;"+regtime;



		///////////////////
		if ( parseInt(response[0])<min_depth || parseInt(response[0])>max_depth ) {
			depthColorCode.classList.remove('bg-danger','bg-success');
			depthColorCode.classList.add('bg-danger');

			depthTextCode.innerHTML = 'Abnormal';
		}
		else {
			depthColorCode.classList.remove('bg-danger','bg-success');
			depthColorCode.classList.add('bg-success');

			depthTextCode.innerHTML = 'Normal';
		}


		/////////////////
		if ( parseInt(response[1])<min_temp || parseInt(response[1])>max_temp ) {
			tempColorCode.classList.remove('bg-danger','bg-success');
			tempColorCode.classList.add('bg-danger');

			tempTextCode.innerHTML = 'Abnormal';
		}
		else {
			tempColorCode.classList.remove('bg-danger','bg-success');
			tempColorCode.classList.add('bg-success');

			tempTextCode.innerHTML = 'Normal';
		}


		/////////////////
		if ( parseInt(response[3])<min_turb || parseInt(response[3])>max_turb ) {
			turbColorCode.classList.remove('bg-danger','bg-success');
			turbColorCode.classList.add('bg-danger');

			turbTextCode.innerHTML = 'Abnormal';
		}
		else {
			turbColorCode.classList.remove('bg-danger','bg-success');
			turbColorCode.classList.add('bg-success');

			turbTextCode.innerHTML = 'Normal';
		}


		/////////////////
		if ( parseInt(response[2])<min_ph || parseInt(response[2])>max_ph ) {
			phColorCode.classList.remove('bg-danger','bg-success');
			phColorCode.classList.add('bg-danger');

			phTextCode.innerHTML = 'Abnormal';
		}
		else {
			phColorCode.classList.remove('bg-danger','bg-success');
			phColorCode.classList.add('bg-success');

			phTextCode.innerHTML = 'Normal';
		}
	}

	setInterval(updateData,10000);  //refresh
});
</script>
<!--METER SCRIPT ENDS-->

</body>

</html>