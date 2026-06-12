import { useState } from "react";

const RECORDS = {
  "STU-1001": {
    name: "Ava Thompson",
    meta: "Grade 10 — Mathematics 10A",
    rate: "96%",
    history: [
      { date: "Mon, Sep 1, 2025", className: "Mathematics 10A", status: "present" },
      { date: "Tue, Sep 2, 2025", className: "English Literature 10A", status: "present" },
      { date: "Wed, Sep 3, 2025", className: "Mathematics 10A", status: "late" },
      { date: "Thu, Sep 4, 2025", className: "Science 10A", status: "present" },
      { date: "Fri, Sep 5, 2025", className: "World History 10B", status: "absent" },
    ],
  },
  "STU-1042": {
    name: "Liam Carter",
    meta: "Grade 11 — English Literature 11B",
    rate: "92%",
    history: [
      { date: "Mon, Sep 1, 2025", className: "English Literature 11B", status: "present" },
      { date: "Tue, Sep 2, 2025", className: "Chemistry 11A", status: "present" },
      { date: "Wed, Sep 3, 2025", className: "Computer Science 12B", status: "present" },
      { date: "Thu, Sep 4, 2025", className: "English Literature 11B", status: "absent" },
      { date: "Fri, Sep 5, 2025", className: "Chemistry 11A", status: "late" },
    ],
  },
};

function statusLabel(status) {
  return status.charAt(0).toUpperCase() + status.slice(1);
}

export default function Attendance() {
  const [studentId, setStudentId] = useState("");
  const [result, setResult] = useState(null);
  const [error, setError] = useState(false);

  function runSearch(idOverride) {
    const id = (idOverride ?? studentId).trim().toUpperCase();
    const data = RECORDS[id];

    if (!data) {
      setResult(null);
      setError(true);
      return;
    }

    setError(false);
    setResult({ id, ...data });
  }

  function handleHintClick(id) {
    setStudentId(id);
    runSearch(id);
  }

  return (
    <>
      {/* PAGE HERO */}
      <section className="hero page-hero">
        <div className="container">
          <h1>Attendance Check</h1>
          <p className="lead">Enter your Student ID to view your attendance records.</p>
        </div>
      </section>

      {/* LOOKUP */}
      <section className="section section-tight">
        <div className="container">

          <div className="lookup-card">
            <label htmlFor="studentIdInput">Student ID</label>
            <div className="search-row">
              <input
                type="text"
                id="studentIdInput"
                placeholder="e.g. STU-1001"
                value={studentId}
                onChange={(e) => setStudentId(e.target.value)}
                onKeyDown={(e) => {
                  if (e.key === "Enter") runSearch();
                }}
              />
              <button className="btn btn-primary" onClick={() => runSearch()}>
                Search
              </button>
            </div>
            <p className="search-hint">
              Try:{" "}
              <button onClick={() => handleHintClick("STU-1001")}>STU-1001</button>{" "}
              or{" "}
              <button onClick={() => handleHintClick("STU-1042")}>STU-1042</button>
            </p>
            <div className={`search-error ${error ? "show" : ""}`}>
              We couldn't find that Student ID. Please check the ID and try again.
            </div>
          </div>

          {/* RESULT */}
          {result && (
            <div className="result-card show">
              <div className="result-header">
                <div>
                  <h3>{result.name}</h3>
                  <div className="sub">{result.id} · {result.meta}</div>
                </div>
                <div className="rate-badge">
                  <div>{result.rate}</div>
                  <div className="rate-label">ATTENDANCE</div>
                </div>
              </div>
              <table className="attendance-table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Class</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {result.history.map((r, i) => (
                    <tr key={i}>
                      <td>{r.date}</td>
                      <td>{r.className}</td>
                      <td>
                        <span className={`status-tag ${r.status}`}>{statusLabel(r.status)}</span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}

        </div>
      </section>
    </>
  );
}
