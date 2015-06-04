<?php

/*
 * Parse the JSON
 */

$file = "dndResults.json";
$str = file_get_contents($file);
$json = json_decode($str, true);


$lastUpdated = date('m/d/Y',strtotime($json['last_updated']));
$dayMostUsers = date('F jS, Y',strtotime($json['day_most_users'][0]));
//January 2nd, 2015
//print_r($json['classes']);

$classes = $json['classes'];

$price = array();
foreach ($classes as $key => $row)
{
    $classesAvgMinutes[$key] = $row['average_minutes'];
}
//array_multisort($price, SORT_DESC, $inventory);
//print_r($price);
arsort($classesAvgMinutes);
?>


<head>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
		<script src="js/d3.min.js"></script>
</head>



<body>
	
	<div class="container">
		<div id="head-title">
			<div class="head-title">DUNGEONS</div>
			<div class="n">&</div> 
			<div class="head-title-bot">[DATA]</div>
			<div class="head-title-sub">CSE Lab's analytical report of wasted effort</div>
		</div>
		
    <div class="desc">
			The computer science lab at the University of California, San Diego is its own small community.  Students from all aspects , work and die here while working on their CS projects.  Dungeons & Data analyzes this activity, and looks to make this pain transparent.  Enjoy viewing all of our achievements!  
		</div>
    
    <br/>
    
    <div class="smaller">Tracking <b><?php echo number_format($json['total_users']); ?></b> Students | Last Updated <b><?php echo $lastUpdated; ?></b></div>
    <hr/> <!--- laptop icon -->
    
		
    <div class="section">
        <div class="left">
            <i class="fa fa-desktop fa-4x"></i> 
        </div>
        <div class="right">
            <div class="wrap">
                <div class="wrap-title">Total Hours Wasted</div>
                <div class="data-text"><?php echo number_format($json['num_hours']); ?></div>
                <div class="sub-text small">5 years, 4 months, 2 days</div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    
    <hr/>
		
		<div class="section">
        <div class="section-title">Daily Unique Users</div>
				<div class="horizontal-graph">
            <div class="row">
                <div class="row-title"><b>CSE Labs</b></div>
                <div class="row-bar">
									<div class="row-bar-fill" style="width: 80%; "><?php echo number_format($json['avg_users_day']); ?> <span class="small">doomed souls</span></div>
                </div>
            </div>
            
            <div class="row">
                <div class="row-title">Tapioca Express</div>
                <div class="row-bar">
									<div class="row-bar-fill" style="width: 60%;">324 <span class="small">milk teas</span></div>
                </div>
            </div>
					
					<div class="row">
                <div class="row-title">Santorini</div>
                <div class="row-bar">
									<div class="row-bar-fill" style="width: 50%;">289 <span class="small">gyros</span></div>
                </div>
            </div>
					
            
            <div class="clear"></div>
        </div>
		</div>
		
		<hr/>
    
    <div class="section">
        <div class="section-title">Hourly Traffic by Day</div>
				<div class="line-graph">
					<svg id="visualisation" width="1000" height="315"></svg>
					<script>
 function InitChart() {
                    var data = [{
                        "sale": "202",
                        "year": "2000"
                    }, {
                        "sale": "215",
                        "year": "2002"
                    }, {
                        "sale": "179",
                        "year": "2004"
                    }, {
                        "sale": "199",
                        "year": "2006"
                    }, {
                        "sale": "134",
                        "year": "2008"
                    }, {
                        "sale": "176",
                        "year": "2010"
                    }];
                    var data2 = [{
                    }];
                    var vis = d3.select("#visualisation"),
                        WIDTH = 750,
                        HEIGHT = 300,
                        MARGINS = {
                            top: 20,
                            right: 20,
                            bottom: 20,
                            left: 50
                        },
                        xScale = d3.scale.linear().range([MARGINS.left, WIDTH - MARGINS.right]).domain([2000, 2010]),
                        yScale = d3.scale.linear().range([HEIGHT - MARGINS.top, MARGINS.bottom]).domain([134, 215]),
                        xAxis = d3.svg.axis()
                        .scale(xScale),
                        yAxis = d3.svg.axis()
                        .scale(yScale)
                        .orient("left");
                    
                    vis.append("svg:g")
                        .attr("class", "x axis")
                        .attr("transform", "translate(0," + (HEIGHT - MARGINS.bottom) + ")")
                        .call(xAxis);
                    vis.append("svg:g")
                        .attr("class", "y axis")
                        .attr("transform", "translate(" + (MARGINS.left) + ",0)")
                        .call(yAxis);
                    var lineGen = d3.svg.line()
                        .x(function(d) {
                            return xScale(d.year);
                        })
                        .y(function(d) {
                            return yScale(d.sale);
                        })
                        .interpolate("basis");
                    vis.append('svg:path')
                        .attr('d', lineGen(data))
                        .attr('stroke', 'green')
                        .attr('stroke-width', 2)
                        .attr('fill', 'none');
                    vis.append('svg:path')
                        .attr('d', lineGen(data2))
                        .attr('stroke', 'blue')
                        .attr('stroke-width', 2)
                        .attr('fill', 'none');
                }
                InitChart();
</script>
					
				</div>
				
				<div class=""><b><?php echo $json['busiest_day'][0]; ?></b> is the busiest day, while <b><?php echo $json['slowest_day'][0]; ?></b> is the slowest</div>
    </div>
    
    <hr/>

    <div class="section">
        <div class="section-title">Average Student Hours per Week</div>
        <div class="horizontal-graph">
					<?php
						$i = 0;
						foreach($classesAvgMinutes as $class => $classInfo) {
							$hours = ceil($classInfo/60/7);
							$width = ceil($hours / 21 * 100);
							echo "
								<div class='row'>";
							
							if($i < 2) {
								echo "<div class='row-title'><b>{$class}</b></div>";
							}
							else {
								echo "<div class='row-title'>{$class}</div>";
							}
							
							$i++;
							echo "<div class='row-bar'>
												<div class='row-bar-fill' style='width: {$width}%; '>{$hours}</div>
										</div>
								</div>";
						}
					?>
					
					
            
            <div class="clear"></div>
        </div>
				
				
    </div>
    
    <hr/>
		
		<div class="section">
			<div class="section-title"><i class="fa fa-users"></i> User Data</div>
			<?php
			$i = 1;
			foreach($json['top_users_total_minutes'] as $userInfo) {
				$hours = number_format(ceil($userInfo[1]/60));
				if($i == 1) {
					echo "
						<div class=''><b>{$userInfo[0]}</b> loves the labs... do you?</div>

						<div class='table'>
							<div class='table-row-header'>
								<div class='table-place'>#</div>
								<div class='table-user'>Username</div>
								<div class='table-time'>Total Hours</div>
								<div class='clear'></div>
							</div>
						
						<div class='table-row'>
							<div class='table-place'><i class='fa fa-trophy orange-color'></i></div>
							<div class='table-user'>{$userInfo[0]}</div>
							<div class='table-time'>{$hours}</div>
						</div>";
				}
				else {
					echo "
						<div class='table-row'>
							<div class='table-place'>{$i}</div>
							<div class='table-user'>{$userInfo[0]}</div>
							<div class='table-time'>{$hours}</div>
						</div>";
				}
				$i++;
			}
			
			?>
				<div class="clear"></div>
			</div>
			
			<div class="small">Don't see your name? See if you made the <a href="">top 100</a></div>
			
		</div>
		
		<div class="section">
			<div class=""><b><?php echo $json['longest_streak_days'][0]; ?></b> is determined - he's been in the labs for the past <b>23</b> days!</div>
			<div class="">Unfortunately, that doesn't top <b><?php echo $json['longest_streak_days'][0]; ?>'s</b> all-time record of <b><?php echo $json['longest_streak_days'][1]; ?></b> straight days!</div>
		</div>
			
		<hr/>
			
		<div class="section">
			<div class="section-title"><i class="fa fa-exclamation-triangle"></i> Peak Concurrent Users</div>
			<div class=""><b><?php echo $json['day_most_users'][1]; ?></b> Students overflowed the CSE Labs on <b><?php echo $dayMostUsers; ?></b></div>
		</div>
		
		<div id="footer">
			<div class="small">Special Thanks to <span class="sub-text">Andy Li, Chris Zhu</span></div>
		</div>
    <!--
    <div class="data-text">Currently Tracking <b>121,374</b> Students</div>
    
    <div class="data-text"><b>Friday</b> is the <span class="white">busiest</span> day at the labs, while <b>Saturday</b> is the slowest</div>
    -->
	</div>
</body>