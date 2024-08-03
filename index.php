<?php 

$hotels=[
  [
    'name'=>'Hotel Belvedere',
    'city'=>'Roma',
    'parking'=>true,
    'vote'=>4,
    'distance_to_center'=>10.4
  ],
  [
    'name'=>'Hotel Futura',
    'city'=>'Rimini',
    'parking'=>false,
    'vote'=>2,
    'distance_to_center'=>2
  ],
  [
    'name'=>'Hotel Rivamare',
    'city'=>'Milano',
    'parking'=>true,
    'vote'=>1,
    'distance_to_center'=>1
  ],
  [
    'name'=>'Hotel Bellavista',
    'city'=>'Veneza',
    'parking'=>false,
    'vote'=>5,
    'distance_to_center'=>5.5
  ],
  [
    'name'=>'Hotel Milano',
    'city'=>'Milano',
    'parking'=>false,
    'vote'=>2,
    'distance_to_center'=>50
  ]
];

/**
 * Filters the hotels array based on the provided filters.
 *
 * @param array $hotels The array of hotels to filter.
 * @param array $filters The filters to apply to the hotels.
 * @return array The filtered array of hotels.
 */
function filter_hotels($hotels, $filters) {
  // Filter the hotels array based on the provided filters.
  return array_filter($hotels, function($hotel) use ($filters) {
    // Check if the name filter is not empty and the hotel name does not contain the filter.
    if (!empty($filters['name']) && stripos($hotel['name'], $filters['name']) === false) {
      return false; // If the filter does not match, exclude the hotel from the result.
    }

    // Check if the city filter is not empty and the hotel city does not contain the filter.
    if (!empty($filters['city']) && stripos($hotel['city'], $filters['city']) === false) {
      return false; // If the filter does not match, exclude the hotel from the result.
    }

    // Check if the parking filter is set and the hotel does not have parking.
    if (isset($filters['parking']) && $filters['parking'] && !$hotel['parking']) {
      return false; // If the filter does not match, exclude the hotel from the result.
    }

    // Check if the distance filter is not empty and the hotel distance is greater than the filter.
    if (!empty($filters['distance_to_center']) && $hotel['distance_to_center'] > $filters['distance_to_center']) {
      return false; // If the filter does not match, exclude the hotel from the result.
    }

    return true; // If all filters match, include the hotel in the result.
  });
}

// Gestione dei filtri
$filters = [
  'name' => $_GET['name'] ?? '',
  'city' => $_GET['city'] ?? '',
  'parking' => isset($_GET['parking']),
  'distance_to_center' => $_GET['distance_to_center'] ?? ''
];

$hotels_filtered = filter_hotels($hotels, $filters);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css' integrity='sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==' crossorigin='anonymous'/>
  <title>Tabella</title>
</head>
<body>
  <div class="container mt-5">
    <h1>Tabella Vacanze</h1>

    <div id="app">
      <form action="./index.php" method="get">
        <input type="text" class="form-control mb-3" style="width: 10%;display: inline" name="name" placeholder="Cerca nome">
        <label for="parking">Parcheggio</label>
        <input class="form-check-input" type="checkbox" name="parking" id="parking">
        <label for="city">Citta</label>
        <input class="form-control mb-3" style="width: 10%; display: inline" type="text" name="city" id="city">
        <label for="distance_to_center">Distanza dal centro</label>
        <input class="form-control mb-3" style="width: 10%; display: inline" type="number" name="distance_to_center" id="distance_to_center">
        <input class="btn btn-primary" type="submit" value="Cerca">
      </form>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Citta</th>
            <th>Parcheggio</th>
            <th>Voto</th>
            <th>Distanza dal centro</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($hotels_filtered)) { ?>
          <?php foreach ($hotels_filtered as $hotel) { ?>
            <tr>
              <td> <?php echo htmlspecialchars($hotel['name']); ?></td>
              <td> <?php echo htmlspecialchars($hotel['city']); ?></td>
              <td> <?php echo $hotel['parking']?'Si':'No'; ?></td>
              <td> <?php echo htmlspecialchars($hotel['vote']); ?></td>
              <td> <?php echo htmlspecialchars($hotel['distance_to_center']); ?> km</td>
            </tr>
          <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="5">Nessun risultato</td>
            </tr>
          <?php } ?>
          </tbody>
      </table>
    </div>
  </div>

</body>
</html>