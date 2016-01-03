<meta charset='utf-8'>
<?

$day_works = array(
	"Saturday",
	"Sunday",
	"Monday",
	"Tuesday",
	"Wednesday",
	"Thursday",
	/*"Friday",*/ /*Pray Time in Muslim's World*/
);

$first_day_text = date("Y-m-01 00:00:00");
$first_day = strtotime($first_day_text);

$last_day_text = date("Y-12-31 23:59:59");
$last_day = strtotime($last_day_text);

echo "<center><h1>بيانات عشوائية لأوقات عشوائية منطقية تحاكي حضور موظف خلال عام كامل</h1></center>";
echo "<center><h1>Random Logical Simulation for an Employee's Attendance in SQL Data</h1></center>";

echo "<p>First Day:($first_day_text): UnixTime($first_day)</p>";
echo "<p>Last Day:($last_day_text): UnixTime($last_day)</p>";

echo "<hr/>";

$sql_bone = "([date], [eid], [ename], [ent], [ex])";

$sql = "INSERT INTO hrm_attendance(`date`, eid, ename, ent, ex) VALUES\r\n";

function complete_digits($n, $count = 2, $char = '0'){
	
	$n_str = "$n";

	$c = strlen($n_str);

	if($c >= $count){
		
		return $n;

	}else{

		$result = "";

		for($i = $c; $i > 0; $i--){

			$result .= $char;
		}

		return $result . $n;
	}
}

$sql_rows = [];

for($day = $first_day; $day <= $last_day;  $day += 86400){

	if(in_array(date("l", $day), $day_works)){
		
		$random_morning = complete_digits(rand(8, 9));
		$random_miunte  = complete_digits(rand(0, 59));
		$random_evening = complete_digits(rand(15, 17));

		$random_second = complete_digits(rand(0, 59));

		$job_day_start = "$random_morning:$random_miunte:$random_second";
		
		$random_miunte = complete_digits(rand(0, 59));
		$random_second = complete_digits(rand(0, 59));

		$job_day_finish = "$random_evening:$random_miunte:$random_second";
		
		$date = date("Y-m-d", $day);
		$ent = date("Y-m-d $job_day_start", $day);
		$ex = date("Y-m-d $job_day_finish", $day);

		$sql_rows[] = str_replace(
			[ '[date]', '[eid]', '[ename]',    '[ent]',    '[ex]'],
			["'$date'",       1,  "'Aziz'",   "'$ent'",    "'$ex'"], $sql_bone);
	}

}

$sql .= join(",\r\n", $sql_rows) . ";";

echo "<pre>";
print_r($sql);
echo "</pre>";
