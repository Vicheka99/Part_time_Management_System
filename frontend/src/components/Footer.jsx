import { Link } from "react-router-dom";

export default function Footer() {
  return (
    <footer className="footer-dark">
      <div className="container">
        <div className="footer-grid">
          <div>
            <div className="brand" style={{ marginBottom: "14px" }}>
              <span className="brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2l8 4-8 4-8-4 8-4zm0 6.5l8 4v5l-8 4-8-4v-5l8-4z" />
                </svg>
              </span>
              EduManage
            </div>
            <p>One platform for teachers, students and administrators.</p>
          </div>
          <div>
            <h4>Quick Links</h4>
            <ul>
              <li><Link to="/">Home</Link></li>
              <li><Link to="/about">About</Link></li>
              <li><Link to="/classes">Classes</Link></li>
              <li><Link to="/attendance">Attendance Check</Link></li>
            </ul>
          </div>
          <div>
            <h4>Contact</h4>
            <div className="contact-item">info@edumanage.edu</div>
            <div className="contact-item">+1 (555) 234-5678</div>
            <div className="contact-item">123 School Lane, Springfield</div>
          </div>
        </div>
        <div className="footer-bottom">© 2026 EduManage. All rights reserved.</div>
      </div>
    </footer>
  );
}
