import { useState } from "react";

const ROLES = ["Admin", "Teacher", "Student"];

export default function Login() {
  const [role, setRole] = useState("Admin");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);

  const placeholders = {
    Admin: "admin@springfield.edu",
    Teacher: "teacher@springfield.edu",
    Student: "student@springfield.edu",
  };

  function handleSubmit(e) {
    e.preventDefault();
    // Demo only — replace with real authentication.
    alert(`Signing in as ${role}${email ? ` (${email})` : ""}`);
  }

  return (
    <section className="login-section">
      <div className="container">

        <div className="login-header">
          <div className="login-logo">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l8 4-8 4-8-4 8-4zm0 6.5l8 4v5l-8 4-8-4v-5l8-4z" />
            </svg>
          </div>
          <h1>Welcome back</h1>
          <p>Sign in to your EduManage account</p>
        </div>

        <div className="login-card">
          <div className="role-tabs">
            {ROLES.map((r) => (
              <button
                key={r}
                type="button"
                className={`role-tab ${role === r ? "active" : ""}`}
                onClick={() => setRole(r)}
              >
                {r}
              </button>
            ))}
          </div>

          <form onSubmit={handleSubmit}>
            <div className="login-field">
              <div className="login-field-head">
                <label htmlFor="email">Email address</label>
              </div>
              <input
                type="email"
                id="email"
                placeholder={placeholders[role]}
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>

            <div className="login-field">
              <div className="login-field-head">
                <label htmlFor="password">Password</label>
                <a href="#">Forgot password?</a>
              </div>
              <div className="password-wrap">
                <input
                  type={showPassword ? "text" : "password"}
                  id="password"
                  placeholder="Enter your password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                />
                <button
                  type="button"
                  className="password-toggle"
                  onClick={() => setShowPassword((s) => !s)}
                  aria-label={showPassword ? "Hide password" : "Show password"}
                >
                  {showPassword ? (
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                      <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-10-8-10-8a18.5 18.5 0 0 1 4.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 10 8 10 8a18.5 18.5 0 0 1-2.16 3.19M14.12 14.12a3 3 0 1 1-4.24-4.24" />
                      <path d="M1 1l22 22" />
                    </svg>
                  ) : (
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                      <path d="M1 12s3-8 11-8 11 8 11 8-3 8-11 8-11-8-11-8z" />
                      <circle cx="12" cy="12" r="3" />
                    </svg>
                  )}
                </button>
              </div>
            </div>

            <button type="submit" className="btn btn-primary btn-block">Sign in</button>
          </form>

          <p className="login-demo-note">
            Demo: enter any email/password. Select <strong>Admin</strong>,{" "}
            <strong>Teacher</strong>, or <strong>Student</strong> to access the
            respective dashboard.
          </p>
        </div>

      </div>
    </section>
  );
}
