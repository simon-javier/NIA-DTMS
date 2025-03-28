<style>
    .loader-container{
    height: 100vh;
    background-color: rgba(255, 255, 255, 0.1); 
    position: fixed;
    z-index: 999;
    width: 100%;
    display: none;
}

.loader {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7); 
  }
  
  .dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-right: 6px;
    border-radius: 50%;
    -webkit-animation: dot-pulse2 1.5s ease-in-out infinite;
    animation: dot-pulse2 1.5s ease-in-out infinite;
    z-index: 999;
  }
  
  .dot-1 {
    background-color: #4285f4;
    -webkit-animation-delay: 0s;
    animation-delay: 0s;
  }
  
  .dot-2 {
    background-color: #34a853;
    -webkit-animation-delay: 0.3s;
    animation-delay: 0.3s;
  }
  
  .dot-3 {
    background-color: #fbbc05;
    -webkit-animation-delay: 0.6s;
    animation-delay: 0.6s;
  }
  
  .dot-4 {
    background-color: #ea4335;
    -webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
  }
  
  .dot-5 {
    background-color: #4285f4;
    -webkit-animation-delay: 1.2s;
    animation-delay: 1.2s;
  }
  
  /* Variasi baru */
  .dot-6 {
    background-color: #0f9d58;
    -webkit-animation-delay: 1.5s;
    animation-delay: 1.5s;
  }
  
  .dot-7 {
    background-color: #673ab7;
    -webkit-animation-delay: 1.8s;
    animation-delay: 1.8s;
  }
  
  .dot-8 {
    background-color: #ff5722;
    -webkit-animation-delay: 2.1s;
    animation-delay: 2.1s;
  }
  
  @keyframes dot-pulse2 {
    0% {
      -webkit-transform: scale(0.5);
      transform: scale(0.5);
      opacity: 0.5;
    }
  
    50% {
      -webkit-transform: scale(1);
      transform: scale(1);
      opacity: 1;
    }
  
    100% {
      -webkit-transform: scale(0.5);
      transform: scale(0.5);
      opacity: 0.5;
    }
  }
</style>


<div class="loader-container">
    <div class="loader">
        <div class="dot dot-1"></div>
        <div class="dot dot-2"></div>
        <div class="dot dot-3"></div>
        <div class="dot dot-4"></div>
        <div class="dot dot-5"></div>
        
        <div class="dot dot-6"></div>
        <div class="dot dot-7"></div>
        <div class="dot dot-8"></div>
    </div>
</div>