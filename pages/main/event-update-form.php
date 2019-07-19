<?php
  define('CURRENT_EVENT', 'WFC2019');

  $config = EventUpdates::getConfig(CURRENT_EVENT);

  // $config->offset is the number of hours ahead of GMT.
  $timestamp = time() + 60 * 60 * $config->offset;
  $date = date("F jS - H:i", $timestamp);
?>

<style>
  form {
    max-width: 600px;
    margin: 0 auto;
  }

  .row {
    margin: 20px 0;
  }

  input[type=text],
  input[type=file],
  textarea {
    display: inline-block;
    width: 100%;
    font-size: 1rem;
  }

  textarea {
    min-height: 8rem;
  }

  input[type=submit] {
    background: #E82020;
    display: inline-block;
    border-radius: .5rem;
    padding: .5em;
    color: #fff;
    text-decoration: none;
    border: 0;
    font-size: 1rem;
  }

  .lowlight {
    font-size: .8rem;
    opacity: .8;
  }
</style>

<h1 class="display-font">Event update form</h1>

<p>For the event: '<?php echo $config->name ?>'</p>

<form action="<?php echo BASE_URL?>event-update-post" method="POST" enctype="multipart/form-data" id="form">
  <div class="row">
    <label>Author <input type="text" name="author" /></label>
  </div>
  <div class="row">
    <label>Date <input type="text" name="date" value="<?php echo $date ?>" /></label>
  </div>
  <div class="row">
    <label>Title <input type="text" name="title" /></label>
  </div>
  <div class="row">
    <label>Photo <span class="lowlight">(optional)</span><input type="file" name="photo" /></label>
  </div>
  <div class="row">
    <label>Message <textarea name="message"></textarea></label>
  </div>
  <div class="row">
    <input type="submit" value="Submit">
  </div>

  <input type="hidden" name="event" value="<?php echo CURRENT_EVENT?>" />
</form>


<script>
  const MAX_WIDTH = 1280;
  const MAX_HEIGHT = 1280;

  function handleSubmit(e)
  {
    e.preventDefault();

    const formEl = e.target;
    const elements = Array.from(formEl.elements);
    const fileElement = elements.find(e => e.type === 'file');
    const file = fileElement.files[0];

    let dataurl = null;

    // Create an image
    const img = document.createElement("img");
    // Create a file reader
    const reader = new FileReader();
    // Set the image once loaded into file reader
    reader.onload = function(e)
    {
      img.src = e.target.result;

      img.onload = function () {
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);

        let width = img.width;
        let height = img.height;

        if (width > height) {
          if (width > MAX_WIDTH) {
            height *= MAX_WIDTH / width;
            width = MAX_WIDTH;
          }
        } else {
          if (height > MAX_HEIGHT) {
            width *= MAX_HEIGHT / height;
            height = MAX_HEIGHT;
          }
        }
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0, width, height);

        dataurl = canvas.toDataURL("image/jpeg");

        // Post the data
        const fd = new FormData();
        elements.forEach((e) => {
          if (e === fileElement) {
            const blobBin = atob(dataurl.split(',')[1]);
            const array = [];
            for(let i = 0; i < blobBin.length; i++) {
              array.push(blobBin.charCodeAt(i));
            }
            fd.append(e.name, new Blob([new Uint8Array(array)], {type: 'image/jpeg', name: "photo.jpg"}));
          } else {
            fd.append(e.name, e.value);
          }
        });
        fetch(formEl.action, {
          method: 'POST',
          body: fd
        }).then(function(response) {
            return response.text();
        }).then(function(data) {
          console.log(data);
        });
      } // img.onload
    }
    // Load files into file reader
    reader.readAsDataURL(file);
  }
  document.getElementById('form').addEventListener('submit', handleSubmit);
</script>