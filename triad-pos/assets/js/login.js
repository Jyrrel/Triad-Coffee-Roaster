document.addEventListener("DOMContentLoaded", () => {
  const overlay = document.getElementById("overlay");
  const roleBox = document.getElementById("roleBox");
  const loginBox = document.getElementById("loginBox");
  const roleTitle = document.getElementById("roleTitle");
  const loginBtn = document.getElementById("loginBtn");
  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");
  const signInBtn = document.getElementById("signInBtn");
  const emailInput = document.getElementById("email");

  let selectedRole = null;

  function showError(msg){
    alert(msg);
  }

  loginBtn.addEventListener("click", () => {
    overlay.style.display = "flex";
    roleBox.style.display = "block";
    loginBox.style.display = "none";
    selectedRole = null;
  });

  overlay.addEventListener("click", (e) => {
    if(e.target === overlay){
      overlay.style.display = "none";
    }
  });

  document.querySelectorAll("[data-role]").forEach(button => {
    button.addEventListener("click", () => {
      selectedRole = button.dataset.role; // "Staff" or "Owner"
      roleBox.style.display = "none";
      loginBox.style.display = "block";
      roleTitle.textContent = `Login as ${selectedRole}`;
      emailInput?.focus();
    });
  });

  togglePassword.addEventListener("change", () => {
    passwordInput.type = togglePassword.checked ? "text" : "password";
  });

  async function doLogin(){
    if(!selectedRole) return showError("Please choose Staff or Owner.");
    const email = (emailInput?.value || "").trim();
    const password = (passwordInput?.value || "").trim();
    if(!email || !password) return showError("Please enter email and password.");

    signInBtn.disabled = true;
    signInBtn.textContent = "Signing in...";

    try{
      const res = await fetch("api/login.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({email, password, role: selectedRole.toLowerCase()})
      });
      const data = await res.json();
      if(!data.ok){
        showError(data.message || "Login failed.");
        return;
      }
      window.location.href = data.redirect || "staff.php";
    }catch(err){
      showError("Server error. Please try again.");
    }finally{
      signInBtn.disabled = false;
      signInBtn.textContent = "Sign In";
    }
  }

  signInBtn.addEventListener("click", doLogin);
  passwordInput.addEventListener("keydown", (e)=>{ if(e.key==="Enter") doLogin(); });
  emailInput?.addEventListener("keydown", (e)=>{ if(e.key==="Enter") doLogin(); });
});
