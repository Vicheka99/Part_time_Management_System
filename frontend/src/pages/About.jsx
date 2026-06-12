export default function About() {
  return (
    <>
      {/* PAGE HERO */}
      <section className="hero page-hero">
        <div className="container">
          <span className="badge">ABOUT EDUMANAGE</span>
          <h1>Empowering Education Through Technology</h1>
          <p className="lead">
            EduManage was founded in 2018 with a clear mission: to simplify school
            administration so educators can spend more time teaching and less time on
            paperwork.
          </p>
        </div>
      </section>

      {/* OUR STORY */}
      <section className="section">
        <div className="container">
          <div className="story-grid">
            <div>
              <h2>Our Story</h2>
              <p>
                Springfield Academy began as a small community school with 200 students
                and a vision for excellence. Over the past decade, we've grown into a
                thriving institution serving over 2,400 students from kindergarten
                through grade 12.
              </p>
              <p>
                Recognizing the complexity of managing a modern school, our administrators
                partnered with technology experts to build EduManage — a platform tailored
                specifically to the needs of educational institutions.
              </p>
              <p>
                Today, EduManage powers schools across 12 states, streamlining
                operations, improving communication, and helping students achieve their
                full potential.
              </p>
            </div>
            <div className="story-stats">
              <div className="story-stat">
                <div className="num">2018</div>
                <div className="label">Founded</div>
              </div>
              <div className="story-stat">
                <div className="num">120+</div>
                <div className="label">Schools Served</div>
              </div>
              <div className="story-stat">
                <div className="num">48,000+</div>
                <div className="label">Students Managed</div>
              </div>
              <div className="story-stat">
                <div className="num">12</div>
                <div className="label">States</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* CORE VALUES */}
      <section className="section section-tight">
        <div className="container">
          <div className="section-head">
            <h2>Our Core Values</h2>
            <p>Three principles guide every feature we build.</p>
          </div>
          <div className="values-grid">
            <div className="value-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
              </div>
              <h3>Accuracy</h3>
              <p>Attendance and grades you can trust, recorded the moment they happen.</p>
            </div>
            <div className="value-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z" />
                </svg>
              </div>
              <h3>Simplicity</h3>
              <p>Clean tools that teachers and admin pick up in minutes, not weeks.</p>
            </div>
            <div className="value-card">
              <div className="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <circle cx="9" cy="7" r="4" />
                  <path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2" />
                  <circle cx="18" cy="7" r="3" />
                  <path d="M22 21v-2a3 3 0 0 0-2-2.83" />
                </svg>
              </div>
              <h3>Connection</h3>
              <p>Teachers, students and admin, all working from the same information.</p>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
