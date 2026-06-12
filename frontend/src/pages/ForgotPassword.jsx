import { useState } from "react";
import { Link } from "react-router-dom";

export default function ForgotPassword() {
  const [email, setEmail] = useState("");
  const [submitted, setSubmitted] = useState(false);

  function handleSubmit(e) {
    e.preventDefault();
    // Demo only — wire this up to your real "send reset email" API.
    setSubmitted(true);
  }

  return (
    <section className="login-section">
      <div className="container">

        <div className="login-header">
          <div className="login-logo">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
              <rect x="3" y="11" width="18" height="10" rx="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
          </div>
          <h1>Forgot your password?</h1>
          <p>Enter your email and we'll send you a link to reset it.</p>
        </div>

        <div className="login-card">
          {submitted ? (
            <div className="login-success">
              <div className="login-success-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M22 4L12 14.01l-3-3" />
                  <path d="M21 12v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h11" />
                </svg>
              </div>
              <h3>Check your inbox</h3>
              <p>
                If an account exists for <strong>{email}</strong>, we've sent a
                password reset link to that address.
              </p>
              <Link to="/login" className="btn btn-primary btn-block">
                Back to sign in
              </Link>
            </div>
          ) : (
            <>
              <form onSubmit={handleSubmit}>
                <div className="login-field">
                  <div className="login-field-head">
                    <label htmlFor="reset-email">Email address</label>
                  </div>
                  <input
                    type="email"
                    id="reset-email"
                    placeholder="you@springfield.edu"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                  />
                </div>

                <button type="submit" className="btn btn-primary btn-block">
                  Send reset link
                </button>
              </form>

              <p className="login-demo-note">
                Remembered your password?{" "}
                <Link to="/login" className="login-link">Back to sign in</Link>
              </p>
            </>
          )}
        </div>

      </div>
    </section>
  );
}
