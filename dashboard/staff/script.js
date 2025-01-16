const sidebar = document.querySelector(".sidebar");
const sidebarToggler = document.querySelector(".sidebar-toggler");
const menuToggler = document.querySelector(".menu-toggler");
const main = document.querySelector(".section");

const collapsedSidebarHeight = "56px";
const fullSidebarHeight = "calc(100vh - 32px)";

sidebarToggler.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");
  main.classList.toggle("active");
});

const toggleMenu = (isMenuAction) => {
  sidebar.style.height = isMenuAction
    ? `${sidebar.scrollHeight}px`
    : collapsedSidebarHeight;

  menuToggler.querySelector("span").innerHTML = isMenuAction ? "close" : "menu";
};

menuToggler.addEventListener("click", () => {
  toggleMenu(sidebar.classList.toggle("menu-active"));
});

window.addEventListener("resize", () => {
  if (window.innerHeight >= 800) {
    sidebar.style.height = fullSidebarHeight;
  } else {
    sidebar.classList.remove("collapsed");
    // sidebar.style.height = 'auto';
    toggleMenu(sidebar.classList.contains("menu-active"));
  }
});

const timeElement = document.querySelector(".time");
const dateElement = document.querySelector(".date");

/**
 *
 * @param {Date} date
 */

function formatTime(date) {
  const hours = date.getHours() % 24;
  const mins = date.getMinutes();

  return `${hours.toString().padStart(2, "0")}:${mins
    .toString()
    .padStart(2, "0")}`;
}

/**
 *
 * @param {Date} date
 */

function formatDate(date) {
  const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  const mon = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];

  return `${days[date.getDay()]} ${date.getDate()} ${mon[date.getMonth()]}`;
}

setInterval(() => {
  const now = new Date();

  timeElement.textContent = formatTime(now);
  dateElement.textContent = formatDate(now);
}, 200);

//

//
const getCSSVariable = (variable, fallback) =>
  getComputedStyle(document.documentElement)
    .getPropertyValue(variable)
    .trim() || fallback;

const colorPrimary = getCSSVariable("--color-primary", "#3498db");
const colorLabel = getCSSVariable("--color-label", "#7f8c8d");
const fontFamily = getCSSVariable("--font-family", "Arial, sans-serif");

const sharedStyles = {
  fontFamily: fontFamily,
  colors: colorLabel,
};

const defaultOptions = {
  chart: {
    toolbar: { show: false },
    zoom: { enabled: false },
    width: "100%",
    height: 180,
    offsetY: 18,
  },
  dataLabels: { enabled: false },
};

const areaChartOptions = {
  ...defaultOptions,
  chart: {
    ...defaultOptions.chart,
    type: "area",
  },
  tooltip: {
    enabled: true,
    style: { fontFamily: sharedStyles.fontFamily },
    y: {
      formatter: (value) => `${value.toLocaleString()}`, // Adds commas for thousands
    },
  },
  series: [
    {
      name: "Views",
      data: [15, 50, 18, 90],
    },
  ],
  colors: [colorPrimary],
  fill: {
    type: "gradient",
    gradient: {
      type: "vertical",
      opacityFrom: 1,
      opacityTo: 0,
      stops: [0, 100],
      colorStops: [
        { offset: 0, opacity: 0.2, color: colorPrimary },
        { offset: 100, opacity: 0, color: colorPrimary },
      ],
    },
  },
  stroke: {
    colors: [colorPrimary],
    lineCap: "round",
  },
  grid: {
    borderColor: "rgba(0, 0, 0, 0)",
    padding: {
      top: -30,
      right: 0,
      bottom: -8,
      left: 20, // Increased padding for the left
    },
  },
  markers: {
    strokeColors: colorPrimary,
  },
  yaxis: { show: false },
  xaxis: {
    labels: {
      show: true,
      floating: true,
      style: {
        colors: sharedStyles.colors,
        fontFamily: sharedStyles.fontFamily,
      },
    },
    axisBorder: { show: false },
    crosshairs: { show: false },
    categories: ["Week 1", "Week 2", "Week 3", "Week 4"],
    tickPlacement: "on", // Ensures ticks align with labels properly
  },
};

const renderChart = (selector, options) => {
  const chartElement = document.querySelector(selector);
  if (chartElement) {
    const chart = new ApexCharts(chartElement, options);
    chart.render();
  } else {
    console.error(`Element with selector "${selector}" not found.`);
  }
};

renderChart(".area-chart", areaChartOptions);

document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".date-btn");

  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remove active class from all buttons
      buttons.forEach((btn) => btn.classList.remove("active"));
      // Add active class to the clicked button
      this.classList.add("active");
    });
  });
});
