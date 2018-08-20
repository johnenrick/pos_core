<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class largeDataTicketSeeder extends Seeder
{
    protected $busList = array();
    protected $indexedBusList = array();
    protected $routeList = array();
    protected $routeWithStopList = array();
    protected $conductorList = array();
    protected $driverList = array();
    protected $discountList = array();

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $seedingDatetimeStarted = time();
      echo "Seeding Started At: " . date("m-d-Y H:i:s", $seedingDatetimeStarted) . "\n";
      /***
        Create large amount of transaction for transactions
      **/
      $this->initMaintenables();
      DB:: table('bus_trips')->truncate();
      DB:: table('bus_trip_tickets')->truncate();
      $startingYear = 2017;
      $endYear = date("Y") * 1;
      for($year = $startingYear; $year <= $endYear; $year++){
        $endMonth = 12;
        if($year == $endYear){
          $endMonth = date('m') * 1;
        }
        for($month = 1; $month <= $endMonth; $month++){
          $daysInMonth = cal_days_in_month(CAL_GREGORIAN,$month ,$year);
          $timeStarted = time();
          for($day = 1; $day <= $daysInMonth; $day++){
            $maxBusTrips = rand(15, 120);
            $this->generateBusTrips($maxBusTrips, strtotime("$day-$month-$year 00:00:00"), rand(50, 300));
          }
          echo "$month-$year\n " . (time() - $timeStarted) . " seconds\n";
        }
      }
      $seedingDatetimeEnded = time();
      echo "Seeding Ended At: " . date("m-d-Y H:i:s", $seedingDatetimeEnded)."\n";
      echo "Total Time:" . ($seedingDatetimeEnded - $seedingDatetimeStarted) ." Seconds\n";
    }
    public function generateBusTrips($maxBusTrips, $dateTimestamp, $maxTickets){
      $busTrips = array();
      $busTripCount = $maxBusTrips;
      $startingBusTrip = $this->toArray(DB::table('bus_trips')->orderBy('id', 'desc')->limit(1)->get());
      for($x = 0; $x <= $maxBusTrips; $x++){
        $busListIndex = rand(0, count($this->busList) - 1);
        $conductorListIndex = rand(0, count($this->conductorList) - 1);
        $driverListIndex = rand(0, count($this->driverList) - 1);
        $routeListIndex = rand(0, count($this->routeList) - 1);
        $startDatetime = $dateTimestamp + rand(0, 72000); // upto 20hours so there is 4 hour allowance for buses that starts at 20
        $endDatetime = $startDatetime + 3600 + rand(0, 10800); // travel time has minimum of 1 hour, added upto 3 hours of random duration
        $busTrips[] = array(
          "bus_id" => $this->busList[$busListIndex]["id"],
          "route_id" => $this->routeList[$routeListIndex]['id'],
          "conductor_account_id" => $this->conductorList[$conductorListIndex]["id"],
          "driver_account_id" => $this->driverList[$driverListIndex]["id"],
          "remarks" => "Test".rand(0,1000),
          "created_at" => date("Y-m-d H:i:s", $startDatetime),
          "arrival_datetime" => date("Y-m-d H:i:s", $endDatetime)
        );

      }
      DB:: table('bus_trips')->insert($busTrips);
      $ticketCount = $this->generateBusTripTickets(count($startingBusTrip) ? $startingBusTrip[0]["id"] : 0, $maxTickets);
      echo date("Y-m-d", $dateTimestamp) . " \tTotal Trips:\t$busTripCount\tTotal Ticket:\t$ticketCount\tAve Ticket-Trip:\t" . $ticketCount/$busTripCount. "\n";
    }
    public function generateBusTripTickets($startingBusTripID, $maxTickets){
      $ticketCount = 0;
      $busTrips = $this->toArray(DB::table('bus_trips')->where('id', '>', $startingBusTripID)->get());
      foreach($busTrips as $busTrip){
        $ticketCount += $this->generateTickets(
          $busTrip['id'],
          $busTrip['bus_id'],
          $busTrip['conductor_account_id'],
          $busTrip['route_id'],
          $maxTickets,
          strtotime($busTrip['created_at']),
          strtotime($busTrip['arrival_datetime'])
        );
      }
      return $ticketCount;
    }
    public function generateTickets($busTripID, $busID, $conductorID, $routeID, $maxTickets, $startDatetime, $endDatetime){
      $routeStops = $this->routeWithStopList[$routeID];
      $tickets = array();
      for($x = rand(0, floor($maxTickets * 0.3)); $x <= $maxTickets; $x++){
        $passengerQuantity = rand(1, 15);
        $startRouteIndex = rand(0, count($routeStops) - 1);
        $endRouteIndex = rand($startRouteIndex, count($routeStops) - 1);
        $totalDistance = $this->calculateDistance($routeID, $startRouteIndex, $endRouteIndex);
        $paymentAdjustment = round(mt_rand (20, 100) / 10, 2);
        $subTotal = $this->indexedBusList[$busID]['base_price'] + $this->indexedBusList[$busID]['price_per_distance'] * $totalDistance;
        $discountListIndex = rand(0, count($this->discountList) - 1);
        $discountAmount = $discountListIndex ? $subTotal * ($this->discountList[$discountListIndex]['value'] / 100) : 0;
        $totalAmount = round($subTotal + $paymentAdjustment - $discountAmount, 2) ;
        $datetimeIssued = rand($startDatetime, $endDatetime);
        $tickets[] = array(
          "bus_trip_id" => $busTripID,
          "conductor_account_id" => $conductorID,
          "passenger_quantity" => $passengerQuantity,
          "start_route_stop_id" => $routeStops[$startRouteIndex]['id'],
          "end_route_stop_id" => $routeStops[$endRouteIndex]['id'],
          "total_distance" => $totalDistance,
          "total_amount" => $totalAmount,
          "payment_adjustment" => $paymentAdjustment,
          "discount_id" => $this->discountList[$discountListIndex]['id'],
          "discount_amount" => $discountAmount,
          "cash_tendered" => ceil( $totalAmount / 100 ) * 100,
          "status" => 1,
          "remarks" => "",
          "created_at" => date("Y-m-d H:i:s", $datetimeIssued)
        );
        // print_r($ticket);

      }
      DB::table('bus_trip_tickets')->insert($tickets);
      return count($tickets);
    }
    public function calculateDistance($routeID, $startRouteIndex, $endRouteIndex){
      $totalDistance = 0;
      $routeStops = $this->routeWithStopList[$routeID];
      for($routeStopIndex = $startRouteIndex + 1 ; $routeStopIndex <= $endRouteIndex; $routeStopIndex++){
        $totalDistance += $routeStops[$routeStopIndex]['distance'];
      }
      return $totalDistance;
    }
    public function initMaintenables(){
      $this->busList = $this->toArray(DB::table('buses')->leftJoin('bus_types', 'bus_types.id', 'buses.bus_type_id')->get());
      $this->routeList = $this->toArray(DB::table('routes')->get());
      $this->conductorList = $this->toArray(DB::table('accounts')->where('account_type_id', 4)->get());
      $this->driverList = $this->toArray(DB::table('accounts')->where('account_type_id', 3)->get());
      $this->routeWithStopList = array();
      $this->discountList = $this->toArray(DB::table('discounts')->get());
      for($x = 0; $x < count($this->routeList); $x++){
        $this->routeWithStopList[$this->routeList[$x]['id']] = $this->toArray(DB::table('route_stops')->where('route_id', $this->routeList[$x]['id'])->get());
      }
      foreach($this->busList as $bus){
        $this->indexedBusList[$bus['id']] = $bus;
      }
    }
    public function toArray($stdObject){
      return json_decode(json_encode($stdObject), true);
    }
}
