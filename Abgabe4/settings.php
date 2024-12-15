<!DOCTYPE html>

<html>
  <head>
    <title>Profile Settings</title>
    <link rel="stylesheet" href="./style.css" />
    <?php require("start.php"); ?>
  </head>

  <body>
    <h1 class="h1left">Profile Settings</h1>
    <fieldset>
      <legend class="top-descriptor">Base Data</legend>
      <br />
      <label class="input-descriptor">First Name</label>
      <input placeholder="Your name" />
      <br />
      <label class="input-descriptor">Last Name</label>
      <input placeholder="Your surname" />
      <br />
      <label class="input-descriptor">Coffe of Tea?</label>
      <select>
        <option value="">Neither nor</option>
        <option value="">Coffee</option>
        <option value="">Tea</option>
      </select>
    </fieldset>
    <br />
    <fieldset>
      <legend class="top-descriptor">Tell Something About You</legend>
      <textarea placeholder="Leave a comment here"></textarea>
    </fieldset>
    <br />
    <fieldset>
      <legend class="top-descriptor">Prefered Chat Layout</legend>
      <br />
      <form>
        <label class="input-descriptor radiobuttonlayout">
          <input
            class="radiobuttons"
            type="radio"
            name="layout_choice"
            value="Username and message in one line"
          />
          Username and message in one line
        </label>
        <br />
        <label class="input-descriptor radiobuttonlayout">
          <input
            class="radiobuttons"
            type="radio"
            name="layout_choice"
            value="Username and message in seperated lines"
          />
          Username and message in seperated lines
        </label>
      </form>
      <br />
    </fieldset>
    <br />
    <form action="settings.html">
    <div>
      <a href="friends.html"><button class="regular-button" type="button">Cancel</button></a>
      <button class="primary-action-button" type="submit">Save</button>
    </div>
  </form>
  </body>
</html>