document.addEventListener("DOMContentLoaded", function () {
    var btn = document.getElementById("download-btn");
    var container = document.getElementById("attestation");
    if (!btn || !container) {
        console.error("Required elements not found: download button or attestation container");
        return;
    }
    // Make sure button is properly styled and visible
    btn.style.display = "inline-block";
    btn.style.padding = "10px 20px";
    btn.style.backgroundColor = "#3b82f6"; // Blue
    btn.style.color = "white";
    btn.style.border = "none";
    btn.style.borderRadius = "4px";
    btn.style.cursor = "pointer";
    btn.style.fontWeight = "bold";
    btn.style.transition = "background-color 0.3s ease";
    // Add hover effect
    btn.addEventListener("mouseenter", function () {
        btn.style.backgroundColor = "#1e40af"; // Darker blue
    });
    btn.addEventListener("mouseleave", function () {
        btn.style.backgroundColor = "#3b82f6"; // Back to original blue
    });
    btn.addEventListener("click", function () {
        var _a;
        // Check if jsPDF is loaded
        var jsPDF = (_a = window.jspdf) === null || _a === void 0 ? void 0 : _a.jsPDF;
        if (!jsPDF) {
            console.error("jsPDF library not available. Make sure to include the script in your HTML.");
            alert("PDF generation library not available. Please check console for more details.");
            return;
        }
        try {
            // Get student data from the container's data attributes
            var nom = container.dataset.nom || "NOM";
            var prenom = container.dataset.prenom || "PRENOM";
            var naissance = container.dataset.dateNaissance || "";
            var username = container.dataset.username || "etudiant";
            var classe = container.dataset.classe || "Filière non spécifiée";
            // Create document with better margins
            var doc_1 = new jsPDF({
                orientation: "portrait",
                unit: "mm",
                format: "a4"
            });
            // Constants for layout
            var pageWidth_1 = doc_1.internal.pageSize.getWidth();
            var pageHeight = doc_1.internal.pageSize.getHeight();
            var margin = 20;
            var contentWidth = pageWidth_1 - 2 * margin;
            // Colors
            var primaryColor = [59, 130, 246]; // Blue
            var secondaryColor = [30, 64, 175]; // Dark blue
            var accentColor = [79, 70, 229]; // Indigo
            var textColor = [31, 41, 55]; // Dark gray
            var lightTextColor = [107, 114, 128]; // Medium gray
            // Add page background with subtle gradient effect
            var fillGradient = function (y, height, color1, color2) {
                var steps = 40;
                var stepHeight = height / steps;
                for (var i = 0; i < steps; i++) {
                    var ratio = i / steps;
                    var r = Math.floor(color1[0] + (color2[0] - color1[0]) * ratio);
                    var g = Math.floor(color1[1] + (color2[1] - color1[1]) * ratio);
                    var b = Math.floor(color1[2] + (color2[2] - color1[2]) * ratio);
                    doc_1.setFillColor(r, g, b);
                    doc_1.rect(0, y + (i * stepHeight), pageWidth_1, stepHeight + 0.5, 'F');
                }
            };
            // Add very subtle background gradient
            fillGradient(0, pageHeight, [252, 252, 253], [248, 250, 252]);
            // Add decorative border
            doc_1.setDrawColor.apply(doc_1, primaryColor);
            doc_1.setLineWidth(0.8);
            doc_1.roundedRect(margin - 5, margin - 5, contentWidth + 10, pageHeight - 2 * margin + 10, 3, 3, 'S');
            // Add inner border (more elegant)
            doc_1.setDrawColor.apply(doc_1, secondaryColor);
            doc_1.setLineWidth(0.3);
            doc_1.roundedRect(margin - 2, margin - 2, contentWidth + 4, pageHeight - 2 * margin + 4, 2, 2, 'S');
            // Add header with gradient effect
            doc_1.setFillColor.apply(doc_1, primaryColor);
            doc_1.roundedRect(margin, margin, contentWidth, 20, 2, 2, 'F');
            // Add school name on header
            doc_1.setFont("helvetica", "bold");
            doc_1.setFontSize(14);
            doc_1.setTextColor(255, 255, 255);
            doc_1.text("ÉCOLE SUPÉRIEURE DE TECHNOLOGIE DE SALE", pageWidth_1 / 2, margin + 12, { align: "center" });
            // Try to add school logo
            var logoImg = document.querySelector(".school-logo");
            if (logoImg === null || logoImg === void 0 ? void 0 : logoImg.complete) {
                try {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    if (ctx) {
                        canvas.width = logoImg.naturalWidth;
                        canvas.height = logoImg.naturalHeight;
                        ctx.drawImage(logoImg, 0, 0);
                        var dataUrl = canvas.toDataURL('image/png');
                        doc_1.addImage(dataUrl, 'PNG', pageWidth_1 / 2 - 22, margin + 30, 44, 44);
                    }
                }
                catch (e) {
                    console.warn("Could not add logo:", e);
                }
            }
            else {
                // Fallback if no logo: draw a placeholder
                doc_1.setDrawColor.apply(doc_1, accentColor);
                doc_1.setLineWidth(0.5);
                doc_1.circle(pageWidth_1 / 2, margin + 52, 22, 'S');
                doc_1.setFontSize(12);
                doc_1.setTextColor.apply(doc_1, accentColor);
                doc_1.text("EST SALE", pageWidth_1 / 2, margin + 52, { align: "center" });
            }
            // Document title with decorative elements
            doc_1.setFont("helvetica", "bold");
            doc_1.setFontSize(24);
            doc_1.setTextColor.apply(doc_1, secondaryColor);
            // Title
            doc_1.text("ATTESTATION DE SCOLARITÉ", pageWidth_1 / 2, margin + 95, { align: "center" });
            // Draw decorative lines after title
            doc_1.line(margin + 40, margin + 102, pageWidth_1 / 2 - 42, margin + 102);
            doc_1.line(pageWidth_1 / 2 + 42, margin + 102, pageWidth_1 - margin - 40, margin + 102);
            // Academic year
            var currentYear = new Date().getFullYear();
            var academicYear = "".concat(currentYear - 1, "-").concat(currentYear);
            doc_1.setFont("helvetica", "italic");
            doc_1.setFontSize(12);
            doc_1.setTextColor.apply(doc_1, accentColor);
            doc_1.text("Ann\u00E9e Acad\u00E9mique ".concat(academicYear), pageWidth_1 / 2, margin + 115, { align: "center" });
            // Document reference number (unique identifier)
            var refNumber = "REF: ".concat(Math.floor(Math.random() * 900000) + 100000, "/").concat(currentYear);
            doc_1.setFont("helvetica", "normal");
            doc_1.setFontSize(9);
            doc_1.text(refNumber, margin, margin + 115);
            // Main content
            var fullName = "".concat(prenom, " ").concat(nom).toUpperCase();
            var formattedDate = naissance ? new Date(naissance).toLocaleDateString("fr-FR") : "Non spécifié";
            var today = new Date().toLocaleDateString("fr-FR", {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
            var y = margin + 135;
            var lineHeight = 8;
            var paragraphSpacing = 15;
            doc_1.setFont("helvetica", "normal");
            doc_1.setFontSize(12);
            doc_1.setTextColor.apply(doc_1, textColor);
            // First paragraph
            doc_1.text("Le Directeur de l'École Supérieure de Technologie de Sale atteste que :", margin + 4, y);
            y += paragraphSpacing;
            // Create a light highlight box for student info
            doc_1.setFillColor(240, 249, 255); // Very light blue
            doc_1.roundedRect(margin, y - 5, contentWidth, 30, 2, 2, 'F');
            doc_1.setDrawColor.apply(doc_1, primaryColor);
            doc_1.setLineWidth(0.3);
            doc_1.roundedRect(margin, y - 5, contentWidth, 30, 2, 2, 'S');
            // Student info
            doc_1.setFont("helvetica", "bold");
            doc_1.text("L'\u00E9tudiant(e) : ".concat(fullName), margin + 80, y, { align: "center" });
            y += lineHeight + 2;
            doc_1.setFont("helvetica", "normal");
            doc_1.text("N\u00E9(e) le : ".concat(formattedDate), margin + 60, y);
            y += lineHeight + 2;
            doc_1.text("Fili\u00E8re : ".concat(classe), margin + 55, y);
            y += paragraphSpacing + 10;
            // Second paragraph
            doc_1.text("est régulièrement inscrit(e) en qualité d'étudiant(e) dans notre établissement", margin + 4, y);
            y += lineHeight;
            doc_1.text("pour l'ann\u00E9e universitaire ".concat(academicYear, "."), margin + 4, y);
            y += paragraphSpacing;
            // Third paragraph
            doc_1.text("La présente attestation est délivrée à l'intéressé(e) pour servir et valoir ce que", margin + 4, y);
            y += lineHeight;
            doc_1.text("de droit.", margin + 4, y);
            y += paragraphSpacing * 2;
            // Date and place
            doc_1.text("Fait \u00E0 Sale, le ".concat(today), pageWidth_1 - margin, y, { align: "right" });
            y += paragraphSpacing;
            // Set up the drawing context
            var stampX = margin + 150;
            var stampY = y - 35;
            var strokeColor = [30, 64, 175]; // #1e40af
            var textColorCircle = [30, 64, 175];
            // Draw outer decorative ring
            /*doc.setDrawColor(...strokeColor);
            doc.setLineWidth(0.75);
            doc.circle(stampX, stampY, 10, 'S');*/
            // Draw inner border ring
            doc_1.setLineWidth(0.3);
            doc_1.circle(stampX, stampY, 15, 'S');
            // Optional faint fill inside circle (like a light stamp background)
            doc_1.setFillColor(240, 246, 255);
            doc_1.circle(stampX, stampY, 10, 'F');
            // Add institution name and location
            doc_1.setFont("helvetica", "bold");
            doc_1.setFontSize(5);
            doc_1.setTextColor.apply(doc_1, textColorCircle);
            doc_1.text("ÉCOLE SUPÉRIEURE", stampX, stampY - 8.5, { align: "center" });
            doc_1.text("DE TECHNOLOGIE", stampX, stampY - 2, { align: "center" });
            doc_1.setFont("helvetica", "bold");
            doc_1.setFontSize(6);
            doc_1.text("SALE", stampX, stampY + 5, { align: "center" });
            // Optional: Add a signature line or seal label
            doc_1.setFont("helvetica", "italic");
            doc_1.setFontSize(6.5);
            doc_1.text("Cachet Officiel", stampX, stampY + 13, { align: "center" });
            // Add verification text
            doc_1.setFontSize(7);
            doc_1.setTextColor.apply(doc_1, lightTextColor);
            doc_1.text("Vérifiez l'authenticité de ce document sur www.ests.uca.ma avec le code de référence " + refNumber.split(": ")[1], margin, pageHeight - margin - 5);
            // Footer note
            doc_1.setFontSize(8);
            doc_1.setTextColor.apply(doc_1, lightTextColor);
            doc_1.text("Document généré électroniquement - Valable sans signature", pageWidth_1 / 2, pageHeight - 10, { align: "center" });
            // Subtle watermark
            doc_1.setFontSize(70);
            doc_1.setTextColor(220, 230, 255);
            doc_1.setGState(new doc_1.GState({ opacity: 0.06 }));
            doc_1.text("EST SAFI", pageWidth_1 / 2, pageHeight / 2, {
                align: "center",
                angle: 45
            });
            // Reset opacity
            doc_1.setGState(new doc_1.GState({ opacity: 1 }));
            // Save the PDF with a proper filename
            doc_1.save("Attestation_Scolarit\u00E9_".concat(username, "_").concat(new Date().toISOString().slice(0, 10), ".pdf"));
            // Provide visual feedback that download started
            var originalText_1 = btn.textContent;
            btn.textContent = "Téléchargement...";
            btn.style.backgroundColor = "#10B981"; // Green
            // Reset button after a short delay
            setTimeout(function () {
                btn.textContent = originalText_1;
                btn.style.backgroundColor = "#3b82f6";
            }, 2000);
        }
        catch (error) {
            console.error("Error generating PDF:", error);
            alert("Une erreur s'est produite lors de la génération du PDF. Veuillez réessayer.");
        }
    });
});
