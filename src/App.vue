<template>
  <div id="app">
    <div class="container">
      <router-view />
    </div>

    <footer>
      <div>
        <p>Scandiweb test assignement</p>
        <p>
          @
          <a href="https://www.linkedin.com/in/youcef-khaoua-b4a38b177/" target="blank"
            >Youcef Khaoua</a
          >
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {};
</script>

<style>
@import "./assets/style.css";
.container {
  min-height: calc(
    100vh - 60px - 60px
  ); /* 60px: margin-top + margin-bottom of the container, 60px: height of the footer */
  margin: 30px 70px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid;
  margin-bottom: 20px;
  padding-bottom: 10px;
}
.header button {
  cursor: pointer;
}

footer {
  display: flex;
  background: white;
  height: 60px;
  width: 100%;
  padding: 0 70px;
  align-items: center;
}

footer div {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 100%;
  height: 100%;
  border-top: 2px solid;
  padding: 20px 0;
  font-size: 1rem;
  font-family: sans-serif;
}

footer a {
  color: #4646ff;
}

@media (max-width: 640px) {
  .header{
    flex-direction: column;
  }

  .actions{
    display: flex;
  }
}
</style>
