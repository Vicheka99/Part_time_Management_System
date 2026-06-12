import { NavLink, Link } from "react-router-dom";

export default function Navbar() {
  const linkClass = ({ isActive }) => (isActive ? "active" : "");

  return (
    <>
      <div className="topbar"></div>
      <header className="navbar">
        <Link to="/" className="brand">
          <span className="brand-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l8 4-8 4-8-4 8-4zm0 6.5l8 4v5l-8 4-8-4v-5l8-4z" />
            </svg>
          </span>
          EduManage
        </Link>
        <nav className="nav-links">
          <NavLink to="/" className={linkClass} end>
            Home
          </NavLink>
          <NavLink to="/about" className={linkClass}>
            About
          </NavLink>
          <NavLink to="/classes" className={linkClass}>
            Classes
          </NavLink>
          <NavLink to="/attendance" className={linkClass}>
            Attendance Check
          </NavLink>
        </nav>
        <div className="nav-right">
          <Link to="/login" className="btn btn-primary btn-sm">
            Login
          </Link>
        </div>
      </header>
    </>
  );
}
