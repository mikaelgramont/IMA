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

  .errors {
    color: #E82020;
  }
  .hidden {
    display: none;
  }
</style>

<h1 class="display-font">Event update form</h1>

<p>For the event: '<?php echo $config->name ?>'</p>

<form action="<?php echo BASE_URL?>event-update-post?XDEBUG_SESSION_START=PHPSTORM" method="POST" enctype="multipart/form-data" id="form">
  <pre class="errors hidden" id="errors"></pre>

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

  const getOrientation = (file) => {
    return new Promise(resolve => {
      const reader = new FileReader();
      reader.addEventListener('load', (event) => {
        const view = new DataView(event.target.result);

        if (view.getUint16(0, false) !== 0xFFD8) {
          resolve(-2);
          return;
        }

        const length = view.byteLength;
        let offset = 2;

        while (offset < length) {
          const marker = view.getUint16(offset, false);
          offset += 2;

          if (marker === 0xFFE1) {
            if (view.getUint32(offset += 2, false) !== 0x45786966) {
              resolve(-1);
              return;
            }
            const little = view.getUint16(offset += 6, false) === 0x4949;
            offset += view.getUint32(offset + 4, little);
            const tags = view.getUint16(offset, little);
            offset += 2;

            for (let i = 0; i < tags; i++)
              if (view.getUint16(offset + (i * 12), little) === 0x0112)
                resolve(view.getUint16(offset + (i * 12) + 8, little));
            return;
          }
          else if ((marker & 0xFF00) !== 0xFF00) break;
          else offset += view.getUint16(offset, false);
        }
        resolve(-1);
      });
      reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
    });
  };

  const getBlob = (file, orientation) => {
    return new Promise((resolve) => {
      // Create an image
      const img = document.createElement("img");
      // Create a file reader
      const reader = new FileReader();
      reader.addEventListener('load', (e) => {
        img.src = e.target.result

        img.addEventListener('load', () => {

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

          if (4 < orientation && orientation < 9) {
            // Switch dimensions because we're going to rotate the content 90 degrees.
            canvas.width = height;
            canvas.height = width;
          } else {
            canvas.width = width;
            canvas.height = height;
          }

          // transform context before drawing image
          switch (orientation) {
            case 2: ctx.transform(-1, 0, 0, 1, width, 0); break;
            case 3: ctx.transform(-1, 0, 0, -1, width, height ); break;
            case 4: ctx.transform(1, 0, 0, -1, 0, height ); break;
            case 5: ctx.transform(0, 1, 1, 0, 0, 0); break;
            case 6: ctx.transform(0, 1, -1, 0, height , 0); break;
            case 7: ctx.transform(0, -1, -1, 0, height , width); break;
            case 8: ctx.transform(0, -1, 1, 0, 0, width); break;
            default: break;
          }

          ctx.drawImage(img, 0, 0, width, height);

          const dataurl = canvas.toDataURL("image/jpeg");
          const blobBin = atob(dataurl.split(',')[1]);
          const array = [];
          for (let i = 0; i < blobBin.length; i++) {
            array.push(blobBin.charCodeAt(i));
          }
          resolve(new Blob([new Uint8Array(array)], { type: 'image/jpeg', name: "photo.jpg" }));
        });
      });
      reader.readAsDataURL(file);
    });
  };

  document.getElementById('form').addEventListener('submit', (e) =>
  {
    e.preventDefault();

    const formEl = e.target;
    const elements = Array.from(formEl.elements);
    const fileElement = elements.find(e => e.type === 'file');
    const file = fileElement.files[0];
    let p;
    if (file) {
      p = getOrientation(file).then((orientation) => {
        return getBlob(file, orientation);
      });
    } else {
      p = Promise.resolve(null);
    }

    p.then((fileBlob) => {
      console.log({fileBlob});
      const fd = new FormData();
      elements.forEach((e) => {
        if (e === fileElement) {
          if (fileBlob) {
            fd.append(e.name, fileBlob);
          }
        } else {
          fd.append(e.name, e.value);
        }
      });
      return fetch(formEl.action, {
        method: 'POST',
        body: fd
      });
    }).then((response) => {
      return response.json();
    }).then((data) => {
      const hasErrors = data.errors && Object.entries(data.errors).length > 0;
      const errorEl = document.getElementById('errors');
      errorEl.innerText = hasErrors ? Object.entries(data.errors).map(([n, m]) => (`${n}: ${m}`)).join('\n') : '';
      errorEl.classList.toggle('hidden', !hasErrors);

      if (data.redirect) {
        window.location.href = data.redirect;
      }
    }).catch((e) => {
      console.error(e);
    });
  });
</script>