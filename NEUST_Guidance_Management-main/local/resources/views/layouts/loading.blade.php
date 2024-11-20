<style>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
  }

.loading-content {
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: white;
  }

.loader-container {
  position: relative;
  width: 120px;
  height: 120px;
  margin-bottom: 20px; /* Space between the spinner and text */
  }

.loader {
  border: 16px solid #ffffff; /* Light grey */
  border-radius: 50%;
  border-top: 16px solid #4169e1; /* Top border color */
  border-bottom: 16px solid #4169e1; /* Bottom border color */
  width: 100%;
  height: 100%;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
  }

.loading-logo {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 60px; /* Adjust the size as needed */
  height: 60px; /* Maintain aspect ratio */
  }

.loading-text {
  margin-top: 20px; /* Space between the spinner and text */
  font-size: 16px;
  }
</style>

<div id="fullPageLoading" class="loading-overlay" style="display: none;">
    <div class="loading-content">
        <div class="loader-container">
            <div class="loader"></div>
            <img src="{{ asset('img/logo.png') }}" alt="Loading..." class="loading-logo">
        </div>
        <p class="loading-text">Please wait...</p>
    </div>
</div>

<script>
    function loadData() {
        document.getElementById('fullPageLoading').style.display = 'flex';

        setTimeout(() => {
            document.getElementById('fullPageLoading').style.display = 'none';
        }, 1000);
    }

    function showLoading() {
        document.getElementById('fullPageLoading').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('fullPageLoading').style.display = 'none';
    }
</script>
