define([], function () {

    return {
        init: function (config) {

            let courses = config?.courses || [];
            const svg = document.getElementById('campus-svg');
            if (!svg){
                return;
            }

            //  DATA FAKE con estado
           /*  if (!courses || courses.length < 7) {
                courses = [
                    { id: 1, fullname: 'Matemáticas Básicas', progress: 100 },
                    { id: 2, fullname: 'Física General', progress: 65 },
                    { id: 3, fullname: 'Química Orgánica', progress: 20 },
                    { id: 4, fullname: 'Programación I', progress: 0 },
                    { id: 5, fullname: 'Historia Universal', progress: 80 },
                    { id: 6, fullname: 'Inglés Avanzado', progress: 40 },
                    { id: 7, fullname: 'Bases de Datos', progress: 10 },
                    { id: 8, fullname: 'Bases de Datos 2 ', progress: 10 },
                    { id: 9, fullname: 'Bases de Datos 3', progress: 10 }
                ];
            } */

            const layout = [
                { x: 0, y: 225, w: 160, h: 130 },
                { x: 120, y: 160, w: 160, h: 130 },
                { x: 250, y: 100, w: 160, h: 130 },
                { x: 380, y: 25, w: 160, h: 130 },
                { x: 530, y: 50, w: 160, h: 130 },
                { x: 650, y: 120, w: 160, h: 130 },
                { x: 780, y: 180, w: 160, h: 130 }
            ];

            courses = courses.slice(0, 7);

            courses.forEach((course, index) => {

                const pos = layout[index % layout.length];

                const group = document.createElementNS("http://www.w3.org/2000/svg", "g");
                group.setAttribute('class', 'building');

                //  estado visual
                let stateClass = 'state-none';
                if (course.progress >= 100){
                    stateClass = 'state-complete';
                } else if (course.progress > 0){
                    stateClass = 'state-progress';
                }

                group.classList.add(stateClass);

                //  edificio aleatorio
                const img = document.createElementNS("http://www.w3.org/2000/svg", "image");

                const randomIndex = Math.floor(Math.random() * 16) + 1;

                img.setAttributeNS(
                    null,
                    'href',
                    M.cfg.wwwroot + '/local/campusview/pix/build_' + randomIndex + '.svg'
                );
                img.setAttribute('x', pos.x);
                img.setAttribute('y', pos.y);
                img.setAttribute('width', pos.w);
                img.setAttribute('height', pos.h);

                group.appendChild(img);
                svg.appendChild(group);

                //  TOOLTIP (HTML overlay)
                const tooltip = document.createElement('div');
                tooltip.className = 'course-tooltip';

                tooltip.innerHTML = `
                    <div class="tooltip-title">${course.fullname}</div>
                    <div class="tooltip-progress">
                        <div class="bar">
                            <div class="fill" style="width:${course.progress}%"></div>
                        </div>
                        <span>${course.progress}%</span>
                    </div>
                    <button class="enter-btn">Entrar</button>
                `;

                document.body.appendChild(tooltip);

                // posicionamiento tooltip
                group.addEventListener('mouseenter', () => {
                    tooltip.style.display = 'block';
                });

                group.addEventListener('mousemove', (e) => {
                    tooltip.style.left = (e.pageX + 15) + 'px';
                    tooltip.style.top = (e.pageY - 20) + 'px';
                });

                group.addEventListener('mouseleave', () => {
                    tooltip.style.display = 'none';
                });

                //  click
                group.addEventListener('click', () => {
                    window.location.href = M.cfg.wwwroot + '/course/view.php?id=' + course.id;
                });

                tooltip.querySelector('.enter-btn').addEventListener('click', () => {
                    window.location.href = M.cfg.wwwroot + '/course/view.php?id=' + course.id;
                });

            });

        }
    };
});