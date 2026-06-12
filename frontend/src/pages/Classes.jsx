import { useMemo, useState } from "react";

const CLASSES = [
  {
    id: 1,
    name: "Mathematics 10A",
    teacher: "Mr. James Wilson",
    subject: "Mathematics",
    tagClass: "blue",
    grade: "Grade 10",
    students: 28,
    schedule: "Mon, Wed, Fri — 8:00 AM",
  },
  {
    id: 2,
    name: "English Literature 11B",
    teacher: "Ms. Sarah Mitchell",
    subject: "English",
    tagClass: "purple",
    grade: "Grade 11",
    students: 25,
    schedule: "Tue, Thu — 9:30 AM",
  },
  {
    id: 3,
    name: "Physics 12A",
    teacher: "Dr. Robert Kim",
    subject: "Science",
    tagClass: "green",
    grade: "Grade 12",
    students: 22,
    schedule: "Mon, Wed — 11:00 AM",
  },
  {
    id: 4,
    name: "Chemistry 11A",
    teacher: "Ms. Linda Torres",
    subject: "Science",
    tagClass: "yellow",
    grade: "Grade 11",
    students: 24,
    schedule: "Tue, Thu, Fri — 10:00 AM",
  },
  {
    id: 5,
    name: "World History 10B",
    teacher: "Mr. Carlos Rivera",
    subject: "History",
    tagClass: "pink",
    grade: "Grade 10",
    students: 30,
    schedule: "Mon, Fri — 1:00 PM",
  },
  {
    id: 6,
    name: "Computer Science 12B",
    teacher: "Ms. Angela Park",
    subject: "Technology",
    tagClass: "cyan",
    grade: "Grade 12",
    students: 20,
    schedule: "Wed, Fri — 2:00 PM",
  },
  {
    id: 7,
    name: "Geometry 9A",
    teacher: "Ms. Rachel Adams",
    subject: "Mathematics",
    tagClass: "blue",
    grade: "Grade 9",
    students: 27,
    schedule: "Tue, Thu — 8:00 AM",
  },
  {
    id: 8,
    name: "Spanish 10A",
    teacher: "Mrs. Elena Cruz",
    subject: "Languages",
    tagClass: "purple",
    grade: "Grade 10",
    students: 23,
    schedule: "Mon, Wed — 1:30 PM",
  },
];

const SUBJECTS = ["Mathematics", "English", "Science", "History", "Technology", "Languages"];
const GRADES = ["Grade 9", "Grade 10", "Grade 11", "Grade 12"];

export default function Classes() {
  const [search, setSearch] = useState("");
  const [grade, setGrade] = useState("all");
  const [subject, setSubject] = useState("all");

  const filtered = useMemo(() => {
    const query = search.trim().toLowerCase();
    return CLASSES.filter((c) => {
      const matchesQuery =
        query === "" ||
        c.name.toLowerCase().includes(query) ||
        c.teacher.toLowerCase().includes(query);
      const matchesGrade = grade === "all" || c.grade === grade;
      const matchesSubject = subject === "all" || c.subject === subject;
      return matchesQuery && matchesGrade && matchesSubject;
    });
  }, [search, grade, subject]);

  return (
    <section className="section section-tight">
      <div className="container">
        <h1 style={{ fontSize: "2.2rem", fontWeight: 800, letterSpacing: "-0.02em", marginBottom: "10px" }}>
          Available Classes
        </h1>
        <p style={{ color: "var(--text-gray)", marginBottom: "32px" }}>
          Browse all classes offered at Springfield Academy for the 2024–2025 academic year.
        </p>

        <div className="filter-bar">
          <input
            type="text"
            placeholder="Search classes or teachers..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
          />
          <select value={grade} onChange={(e) => setGrade(e.target.value)}>
            <option value="all">All Grades</option>
            {GRADES.map((g) => (
              <option key={g} value={g}>{g}</option>
            ))}
          </select>
          <select value={subject} onChange={(e) => setSubject(e.target.value)}>
            <option value="all">All Subjects</option>
            {SUBJECTS.map((s) => (
              <option key={s} value={s}>{s}</option>
            ))}
          </select>
        </div>

        <p className="results-count">{filtered.length} classes found</p>

        <div className="class-grid">
          {filtered.map((c) => (
            <div className="class-card" key={c.id}>
              <div className="class-card-head">
                <span className={`subject-tag ${c.tagClass}`}>{c.subject}</span>
                <span className="grade-badge">{c.grade}</span>
              </div>
              <h3>{c.name}</h3>
              <div className="teacher">{c.teacher}</div>
              <div className="class-meta-row">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <circle cx="12" cy="8" r="4" />
                  <path d="M4 21v-1a8 8 0 0 1 16 0v1" />
                </svg>
                {c.students} students enrolled
              </div>
              <div className="class-meta-row">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <rect x="3" y="4" width="18" height="18" rx="2" />
                  <path d="M3 10h18M8 2v4M16 2v4" />
                </svg>
                {c.schedule}
              </div>
            </div>
          ))}
        </div>

        {filtered.length === 0 && (
          <p style={{ textAlign: "center", color: "var(--text-gray)", marginTop: "40px" }}>
            No classes match your search.
          </p>
        )}
      </div>
    </section>
  );
}
