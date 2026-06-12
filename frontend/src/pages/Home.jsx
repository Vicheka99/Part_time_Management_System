import { Link } from "react-router-dom";

export default function Home() {
  return (
    <>
      {/* HERO */}
      <section className="hero">
        <div className="container">
          <span className="badge">SCHOOL MANAGEMENT SYSTEM</span>
          <h1>
            One platform for{" "}
            <span className="accent">
              teachers,
              <br />
              students
            </span>{" "}
            and admin
          </h1>
          <p className="lead">
            EduManage streamlines school operations — from attendance and scheduling to
            grades and reports — so educators can focus on what matters most: teaching.
          </p>
          <div className="hero-actions">
            <Link to="/attendance" className="btn btn-primary">Get Started</Link>
            <Link to="/about" className="btn btn-outline">Learn More</Link>
          </div>
        </div>

        {/* STATS */}
        <div className="container stats">
          <div className="stats-grid">
            <div className="stat-card">
              <div className="num">2,400+</div>
              <div className="label">Active Students</div>
            </div>
            <div className="stat-card">
              <div className="num">180+</div>
              <div className="label">Qualified Teachers</div>
            </div>
            <div className="stat-card">
              <div className="num">64</div>
              <div className="label">Classes Offered</div>
            </div>
            <div className="stat-card">
              <div className="num">94.7%</div>
              <div className="label">Attendance Rate</div>
            </div>
          </div>
        </div>
      </section>

      {/* FEATURES */}
      <section className="section">
        <div className="container">
          <div className="section-head">
            <span className="badge">FEATURES</span>
            <h2>Everything your school needs</h2>
            <p>One dashboard for every role — built to cut down on paperwork and keep everyone in sync.</p>
          </div>
          <div className="feature-grid">

            <div className="feature-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <rect x="3" y="4" width="18" height="18" rx="2" />
                  <path d="M3 10h18M8 2v4M16 2v4" />
                </svg>
              </div>
              <h3>Attendance Tracking</h3>
              <p>Mark, review and export daily attendance in just a few taps.</p>
            </div>

            <div className="feature-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                </svg>
              </div>
              <h3>Class Scheduling</h3>
              <p>Build conflict-free timetables for every class and teacher.</p>
            </div>

            <div className="feature-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M12 20v-6M6 20V10M18 20V4" />
                </svg>
              </div>
              <h3>Grades &amp; Reports</h3>
              <p>Record grades and generate report cards automatically.</p>
            </div>

            <div className="feature-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <circle cx="12" cy="8" r="4" />
                  <path d="M4 21v-1a8 8 0 0 1 16 0v1" />
                </svg>
              </div>
              <h3>Student Profiles</h3>
              <p>A single record for every student's progress and history.</p>
            </div>

            <div className="feature-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M21 11.5a8.38 8.38 0 0 1-9.4 8.4 9 9 0 1 1 9.4-8.4z" />
                </svg>
              </div>
              <h3>Messaging</h3>
              <p>Keep teachers, students and parents connected in one place.</p>
            </div>

            <div className="feature-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <circle cx="12" cy="12" r="9" />
                  <path d="M12 7v5l3 3" />
                </svg>
              </div>
              <h3>Admin Dashboard</h3>
              <p>Real-time insights into enrollment, staffing and performance.</p>
            </div>

          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="container">
        <div className="cta">
          <h2>Ready to simplify your school?</h2>
          <p>Join hundreds of schools already running smoother with EduManage.</p>
          <div className="cta-actions">
            <Link to="/attendance" className="btn btn-primary">Get Started</Link>
            <Link to="/about" className="btn btn-outline">Learn More</Link>
          </div>
        </div>
      </section>
    </>
  );
}
