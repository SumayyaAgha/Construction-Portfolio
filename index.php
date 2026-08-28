<?php 
include 'db.php'; 

$hero_query = "SELECT * FROM hero LIMIT 1";
$hero_result = mysqli_query($conn, $hero_query);
$hero = mysqli_fetch_assoc($hero_result);
$counters_query = "SELECT * FROM counters ORDER BY display_order ASC";
$counters_result = mysqli_query($conn, $counters_query);

$about_query = "SELECT * FROM about LIMIT 1";
$about_result = mysqli_query($conn, $about_query);
$about = mysqli_fetch_assoc($about_result);
$features_query = "SELECT * FROM about_features ORDER BY display_order ASC";
$features_result = mysqli_query($conn, $features_query);

$services_header_query = "SELECT * FROM services_header LIMIT 1";
$services_header_result = mysqli_query($conn, $services_header_query);
$services_header = mysqli_fetch_assoc($services_header_result);
$service_cards_query = "SELECT * FROM service_cards ORDER BY display_order ASC";
$service_cards_result = mysqli_query($conn, $service_cards_query);

$track_record_query = "SELECT * FROM track_record LIMIT 1";
$track_record_result = mysqli_query($conn, $track_record_query);
$track_record = mysqli_fetch_assoc($track_record_result);
$track_stats_query = "SELECT * FROM track_stats ORDER BY display_order ASC";
$track_stats_result = mysqli_query($conn, $track_stats_query);

$projects_query = "SELECT * FROM projects ORDER BY display_order ASC";
$projects_result = mysqli_query($conn, $projects_query);
$projects_array = [];
while ($row = mysqli_fetch_assoc($projects_result)) {
    $projects_array[] = $row;
}
$projects_json = json_encode($projects_array);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Constructify</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="images/building-plan.png" alt="Construction logo">
            <span>Constructify</span>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="#" onclick="return false;" class="nav-pages">Pages</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="nav-right">
            <a href="tel:+15552346789" class="phone"><i class="fa-solid fa-phone"></i> +1 (555) 234-6789</a>
            <button class="btn-estimate">Get Estimate</button>
        </div>
    </nav>
    <section class="hero" id="home">
    <div class="hero-content">
        <span class="badge"><i class="fa-solid fa-building"></i> <?php echo $hero['badge_text']; ?></span>
        <h1><?php echo $hero['title_line1']; ?><br><?php echo $hero['title_line2']; ?> <span class="highlight"><?php echo $hero['highlight_word']; ?></span></h1>
        <p><?php echo $hero['subtitle']; ?></p>
        <div class="hero-buttons">
            <button class="btn-primary"><?php echo $hero['btn_primary_text']; ?></button>
            <button class="btn-outline"><?php echo $hero['btn_outline_text']; ?></button>
        </div>
    </div>
    <div class="counters">
        <?php while ($row = mysqli_fetch_assoc($counters_result)): ?>
        <div class="counter-item">
            <h2><?php echo $row['number_value']; ?></h2>
            <p><?php echo $row['label']; ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</section>
    <section class="about" id="about">
  <div class="about-images">
    <img src="<?php echo $about['main_image']; ?>" alt="Construction worker" class="about-img-main">
    <img src="<?php echo $about['secondary_image']; ?>" alt="Crane on site" class="about-img-secondary">
    <div class="experience-badge">
      <h3><?php echo $about['badge_number']; ?></h3>
      <p><?php echo $about['badge_label']; ?></p>
    </div>
  </div>

  <div class="about-content">
    <span class="section-label"><img src="images/hook.png">&nbsp;&nbsp; <?php echo $about['label_text']; ?></span>
    <h2><?php echo $about['heading']; ?></h2>
    <p><?php echo $about['description']; ?></p>

    <div class="features-grid">
      <?php while ($feature = mysqli_fetch_assoc($features_result)): ?>
      <div class="feature-item">
        <img src="<?php echo $feature['icon']; ?>" alt="<?php echo $feature['title']; ?>">
        <h4><?php echo $feature['title']; ?></h4>
        <p><?php echo $feature['description']; ?></p>
      </div>
      <?php endwhile; ?>
    </div>

    <div class="about-buttons">
      <button class="btn-primary"><?php echo $about['btn_primary_text']; ?></button>
      <button class="btn-outline-dark"><?php echo $about['btn_outline_text']; ?></button>
    </div>
  </div>
</section>
<section class="services" id="services">
  <div class="services-header">
    <h2><?php echo $services_header['heading']; ?></h2>
    <p><?php echo $services_header['subtitle']; ?></p>
  </div>

  <div class="services-layout">
    <div class="services-image">
      <img src="<?php echo $services_header['side_image']; ?>" alt="Excavator on site">
      <div class="services-image-overlay">
        <h3><?php echo $services_header['overlay_heading']; ?></h3>
        <a href="#" class="services-link"><?php echo $services_header['overlay_link_text']; ?></a>
      </div>
    </div>

    <div class="services-grid">
      <?php while ($card = mysqli_fetch_assoc($service_cards_result)): ?>
      <div class="service-card">
        <img src="<?php echo $card['icon']; ?>" alt="<?php echo $card['title']; ?>">
        <div class="service-card-text">
          <h4><?php echo $card['title']; ?></h4>
          <p><?php echo $card['description']; ?></p>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<section class="track-record" id="track-record">
  <div class="track-content">
    <span class="section-label"><?php echo $track_record['label_text']; ?></span>
    <h2><?php echo $track_record['heading']; ?></h2>
    <p><?php echo $track_record['description']; ?></p>
    <a href="#" class="track-link"><?php echo $track_record['link_text']; ?></a>
  </div>

  <div class="track-grid">
    <?php while ($stat = mysqli_fetch_assoc($track_stats_result)): ?>
    <div class="track-card">
      <div class="track-icon"><img src="<?php echo $stat['icon']; ?>"></div>
      <h3><?php echo $stat['number_value']; ?></h3>
      <p><?php echo $stat['label']; ?></p>
    </div>
    <?php endwhile; ?>
  </div>
</section>
<div id="projects-root"></div>
  <script type="text/babel">
  const projectsData = <?php echo $projects_json; ?>;

  function ProjectsSection() {
    const [activeFilter, setActiveFilter] = React.useState("all");
    const [zoomedImage, setZoomedImage] = React.useState(null);

    const filteredProjects = activeFilter === "all"
      ? projectsData
      : projectsData.filter(p => p.category === activeFilter);

    const filters = ["all", "residential", "commercial", "infrastructure"];

    return (
      <section className="projects" id="projects">
        <div className="projects-header">
          <h2>Our Projects</h2>
          <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        </div>

        <div className="projects-filters">
          {filters.map(f => (
            <button
              key={f}
              className={"filter-btn" + (activeFilter === f ? " active" : "")}
              onClick={() => setActiveFilter(f)}
            >
              {f === "all" ? "All Projects" : f.charAt(0).toUpperCase() + f.slice(1)}
            </button>
          ))}
        </div>

        <div className="projects-grid">
          {filteredProjects.map(project => (
            <div className="project-card" key={project.id}>
              <img src={project.image} alt={project.title} />
              <div className="project-overlay">
                <div className="project-icons">
                  <span className="icon-circle" onClick={() => setZoomedImage(project.image)}>⤢</span>
                  <span className="icon-circle">→</span>
                </div>
              </div>
              <div className="project-info">
                <span className="project-tag">{project.tag_label}</span>
                <h4>{project.title}</h4>
                <p>{project.description}</p>
              </div>
            </div>
          ))}
        </div>

        {zoomedImage && (
          <div className="lightbox-overlay" onClick={() => setZoomedImage(null)}>
            <img src={zoomedImage} className="lightbox-image" />
            <span className="lightbox-close" onClick={() => setZoomedImage(null)}>✕</span>
          </div>
        )}
      </section>
    );
  }
  const root = ReactDOM.createRoot(document.getElementById('projects-root'));
  root.render(<ProjectsSection />);
</script>
<script>
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-links a");

  window.addEventListener("scroll", () => {
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-links a");
  let current = "";

  sections.forEach((section) => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.offsetHeight;
    if (window.scrollY >= sectionTop - 150 && window.scrollY < sectionTop + sectionHeight - 150) {
      current = section.getAttribute("id");
    }
  });

  navLinks.forEach((link) => {
    link.classList.remove("active");
    if (current !== "" && link.getAttribute("href") === "#" + current) {
      link.classList.add("active");
    }
  });
  });
</script>
</body>

</html>