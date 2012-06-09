{extends file="views/layout.tpl"}
{block name=title}Country View - {$country['name']}{/block}
{block name=head}
    {literal}
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?1.29.1"></script>
            <style type="text/css">

        body {
        background: #000;
        }

        ellipse {
        fill: #fff;
        }

        path {
        fill: none;
        stroke: #fff;
        stroke-linecap: round;
        }

        .mid {
        stroke-width: 4px;
        }

        .tail {
        stroke-width: 2px;
        }

    </style>
    {/literal}
{/block}
{block name=body}
    {literal}
<script type="text/javascript">

var w = 960,
    h = 500,
    n = 100,
    m = 12,
    degrees = 180 / Math.PI;

var spermatozoa = d3.range(n).map(function() {
  var x = Math.random() * w, y = Math.random() * h;
  return {
    vx: Math.random() * 2 - 1,
    vy: Math.random() * 2 - 1,
    path: d3.range(m).map(function() { return [x, y]; }),
    count: 0
  };
});

var svg = d3.select("body").append("svg:svg")
    .attr("width", w)
    .attr("height", h);

var g = svg.selectAll("g")
    .data(spermatozoa)
  .enter().append("svg:g");

var head = g.append("svg:ellipse")
    .attr("rx", 6.5)
    .attr("ry", 4);

g.append("svg:path")
    .map(function(d) { return d.path.slice(0, 3); })
    .attr("class", "mid");

g.append("svg:path")
    .map(function(d) { return d.path; })
    .attr("class", "tail");

var tail = g.selectAll("path");

d3.timer(function() {
  for (var i = -1; ++i < n;) {
    var spermatozoon = spermatozoa[i],
        path = spermatozoon.path,
        dx = spermatozoon.vx,
        dy = spermatozoon.vy,
        x = path[0][0] += dx,
        y = path[0][1] += dy,
        speed = Math.sqrt(dx * dx + dy * dy),
        count = speed * 10,
        k1 = -5 - speed / 3;

    // Bounce off the walls.
    if (x < 0 || x > w) spermatozoon.vx *= -1;
    if (y < 0 || y > h) spermatozoon.vy *= -1;

    // Swim!
    for (var j = 0; ++j < m;) {
      var vx = x - path[j][0],
          vy = y - path[j][1],
          k2 = Math.sin(((spermatozoon.count += count) + j * 3) / 300) / speed;
      path[j][0] = (x += dx / speed * k1) - dy * k2;
      path[j][1] = (y += dy / speed * k1) + dx * k2;
      speed = Math.sqrt((dx = vx) * dx + (dy = vy) * dy);
    }
  }

  head.attr("transform", function(d) {
    return "translate(" + d.path[0] + ")rotate(" + Math.atan2(d.vy, d.vx) * degrees + ")";
  });

  tail.attr("d", function(d) {
    return "M" + d.join("L");
  });
});

    </script>
    {/literal}
{/block}