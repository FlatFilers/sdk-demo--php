<?php
require 'vendor/autoload.php';

$EMBED_ID = 'YOUR_EMBED_ID';
$PRIVATE_KEY = 'YOUR_PRIVATE_KEY';
    
$token = \Firebase\JWT\JWT::encode(
  array(
    'embed' => $EMBED_ID,
    'sub' => 'max.blank@flatfile.io'
  ),
  $PRIVATE_KEY
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flatfile SDK Demo</title>
  <script src="https://sdk-v3-beta.s3.us-west-2.amazonaws.com/index.js"></script>
</head>
<body>
  <button id="import">Import Data</button>

  <script>
    const importer = flatfileImporter('<?php echo $token; ?>', {env: 'staging'})

    importer.on('init', ({ batchId }) => {
      console.log(`Batch ${batchId} has been initialized.`)
    })
    importer.on('launch', ({ batchId }) => {
      console.log(`Batch ${batchId} has been launched.`)
    })
    importer.on('error', (error) => {
      console.error(error)
    })
    importer.on('complete', async (payload) => {
      console.log(JSON.stringify(await payload.data(), null, 4))
    })

    document.querySelector('#import').addEventListener('click', async () => {
      await importer.launch()
    })
  </script>
</body>
</html>