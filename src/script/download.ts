document.addEventListener("DOMContentLoaded", (): void => {
    const btn = document.getElementById("download-btn") as HTMLButtonElement | null;
    const container = document.getElementById("attestation") as HTMLElement | null;
    
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
    btn.addEventListener("mouseenter", () => {
      btn.style.backgroundColor = "#1e40af"; // Darker blue
    });
    
    btn.addEventListener("mouseleave", () => {
      btn.style.backgroundColor = "#3b82f6"; // Back to original blue
    });
    
    btn.addEventListener("click", (): void => {
      // Check if jsPDF is loaded
      const jsPDF = (window as any).jspdf?.jsPDF;
      if (!jsPDF) {
        console.error("jsPDF library not available. Make sure to include the script in your HTML.");
        alert("PDF generation library not available. Please check console for more details.");
        return;
      }
      
      try {
        // Get student data from the container's data attributes
        const nom = container.dataset.nom || "NOM";
        const prenom = container.dataset.prenom || "PRENOM";
        const naissance = container.dataset.dateNaissance || "";
        const username = container.dataset.username || "etudiant";
        const classe = container.dataset.classe || "Filière non spécifiée";
        
        // Create document with better margins
        const doc = new jsPDF({
          orientation: "portrait",
          unit: "mm",
          format: "a4"
        });
        
        // Constants for layout
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 20;
        const contentWidth = pageWidth - 2 * margin;
        
        // Colors
        const primaryColor = [59, 130, 246];      // Blue
        const secondaryColor = [30, 64, 175];     // Dark blue
        const accentColor = [79, 70, 229];        // Indigo
        const textColor = [31, 41, 55];           // Dark gray
        const lightTextColor = [107, 114, 128];   // Medium gray
        
        // Add page background with subtle gradient effect
        const fillGradient = (y, height, color1, color2) => {
          const steps = 40;
          const stepHeight = height / steps;
          for (let i = 0; i < steps; i++) {
            const ratio = i / steps;
            const r = Math.floor(color1[0] + (color2[0] - color1[0]) * ratio);
            const g = Math.floor(color1[1] + (color2[1] - color1[1]) * ratio);
            const b = Math.floor(color1[2] + (color2[2] - color1[2]) * ratio);
            
            doc.setFillColor(r, g, b);
            doc.rect(0, y + (i * stepHeight), pageWidth, stepHeight + 0.5, 'F');
          }
        };
        
        // Add very subtle background gradient
        fillGradient(0, pageHeight, [252, 252, 253], [248, 250, 252]);
        
        // Add decorative border
        doc.setDrawColor(...primaryColor);
        doc.setLineWidth(0.8);
        doc.roundedRect(
          margin - 5, 
          margin - 5, 
          contentWidth + 10, 
          pageHeight - 2 * margin + 10, 
          3, 3, 
          'S'
        );
        
        // Add inner border (more elegant)
        doc.setDrawColor(...secondaryColor);
        doc.setLineWidth(0.3);
        doc.roundedRect(
          margin - 2, 
          margin - 2, 
          contentWidth + 4, 
          pageHeight - 2 * margin + 4, 
          2, 2, 
          'S'
        );
        
        // Add header with gradient effect
        doc.setFillColor(...primaryColor);
        doc.roundedRect(
          margin, 
          margin, 
          contentWidth, 
          20, 
          2, 2, 
          'F'
        );
        
        // Add school name on header
        doc.setFont("helvetica", "bold");
        doc.setFontSize(14);
        doc.setTextColor(255, 255, 255);
        doc.text("ÉCOLE SUPÉRIEURE DE TECHNOLOGIE DE SALE", pageWidth / 2, margin + 12, { align: "center" });
        
        // Try to add school logo
        const logoImg = document.querySelector(".school-logo") as HTMLImageElement;
        if (logoImg?.complete) {
          try {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            if (ctx) {
              canvas.width = logoImg.naturalWidth;
              canvas.height = logoImg.naturalHeight;
              ctx.drawImage(logoImg, 0, 0);
              const dataUrl = canvas.toDataURL('image/png');
              doc.addImage(
                dataUrl, 
                'PNG', 
                pageWidth / 2 - 22, 
                margin + 30, 
                44, 
                44
              );
            }
          } catch (e) {
            console.warn("Could not add logo:", e);
          }
        } else {
          // Fallback if no logo: draw a placeholder
          doc.setDrawColor(...accentColor);
          doc.setLineWidth(0.5);
          doc.circle(pageWidth / 2, margin + 52, 22, 'S');
          doc.setFontSize(12);
          doc.setTextColor(...accentColor);
          doc.text("EST SALE", pageWidth / 2, margin + 52, { align: "center" });
        }
        
        // Document title with decorative elements
        doc.setFont("helvetica", "bold");
        doc.setFontSize(24);
        doc.setTextColor(...secondaryColor);
        
        // Title
        doc.text("ATTESTATION DE SCOLARITÉ", pageWidth / 2, margin + 95, { align: "center" });
        
        // Draw decorative lines after title
        doc.line(margin + 40, margin + 102, pageWidth / 2 - 42, margin + 102);
        doc.line(pageWidth / 2 + 42, margin + 102, pageWidth - margin - 40, margin + 102);
        
        // Academic year
        const currentYear = new Date().getFullYear();
        const academicYear = `${currentYear - 1}-${currentYear}`;
        
        doc.setFont("helvetica", "italic");
        doc.setFontSize(12);
        doc.setTextColor(...accentColor);
        doc.text(`Année Académique ${academicYear}`, pageWidth / 2, margin + 115, { align: "center" });
        
        // Document reference number (unique identifier)
        const refNumber = `REF: ${Math.floor(Math.random() * 900000) + 100000}/${currentYear}`;
        doc.setFont("helvetica", "normal");
        doc.setFontSize(9);
        doc.text(refNumber, margin, margin + 115);
        
        // Main content
        const fullName = `${prenom} ${nom}`.toUpperCase();
        const formattedDate = naissance ? new Date(naissance).toLocaleDateString("fr-FR") : "Non spécifié";
        const today = new Date().toLocaleDateString("fr-FR", {
          day: '2-digit',
          month: 'long',
          year: 'numeric'
        });
        
        let y = margin + 135;
        const lineHeight = 8;
        const paragraphSpacing = 15;
        
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);
        doc.setTextColor(...textColor);
        
        // First paragraph
        doc.text("Le Directeur de l'École Supérieure de Technologie de Sale atteste que :", margin + 4, y);
        y += paragraphSpacing;
        
        // Create a light highlight box for student info
        doc.setFillColor(240, 249, 255); // Very light blue
        doc.roundedRect(margin, y - 5, contentWidth, 30, 2, 2, 'F');
        doc.setDrawColor(...primaryColor);
        doc.setLineWidth(0.3);
        doc.roundedRect(margin, y - 5, contentWidth, 30, 2, 2, 'S');
        
        // Student info
        doc.setFont("helvetica", "bold");
        doc.text(`L'étudiant(e) : ${fullName}`, margin + 80, y, { align: "center" });
        y += lineHeight + 2;
        
        doc.setFont("helvetica", "normal");
        doc.text(`Né(e) le : ${formattedDate}`, margin + 60, y);
        y += lineHeight + 2;
        
        doc.text(`Filière : ${classe}`, margin + 55, y);
        y += paragraphSpacing + 10;
        
        // Second paragraph
        doc.text("est régulièrement inscrit(e) en qualité d'étudiant(e) dans notre établissement", margin + 4, y);
        y += lineHeight;
        doc.text(`pour l'année universitaire ${academicYear}.`, margin + 4, y);
        y += paragraphSpacing;
        
        // Third paragraph
        doc.text("La présente attestation est délivrée à l'intéressé(e) pour servir et valoir ce que", margin + 4, y);
        y += lineHeight;
        doc.text("de droit.", margin + 4, y);
        y += paragraphSpacing * 2;
        
        // Date and place
        doc.text(`Fait à Sale, le ${today}`,pageWidth - margin, y, { align: "right" });
        y += paragraphSpacing;
        
        // Set up the drawing context
        const stampX = margin + 150;
        const stampY = y - 35;
        const strokeColor = [30, 64, 175]; // #1e40af
        const textColorCircle = [30, 64, 175];
        
        // Draw outer decorative ring
        /*doc.setDrawColor(...strokeColor);
        doc.setLineWidth(0.75);
        doc.circle(stampX, stampY, 10, 'S');*/
        
        // Draw inner border ring
        doc.setLineWidth(0.3);
        doc.circle(stampX, stampY, 15, 'S');
        
        // Optional faint fill inside circle (like a light stamp background)
        doc.setFillColor(240, 246, 255);
        doc.circle(stampX, stampY, 10, 'F');
        
        // Add institution name and location
        doc.setFont("helvetica", "bold");
        doc.setFontSize(5);
        doc.setTextColor(...textColorCircle);
        doc.text("ÉCOLE SUPÉRIEURE", stampX, stampY - 8.5, { align: "center" });
        doc.text("DE TECHNOLOGIE",   stampX, stampY - 2,   { align: "center" });
        doc.setFont("helvetica", "bold");
        doc.setFontSize(6);
        doc.text("SALE",             stampX, stampY + 5,   { align: "center" });
        
        // Optional: Add a signature line or seal label
        doc.setFont("helvetica", "italic");
        doc.setFontSize(6.5);
        doc.text("Cachet Officiel", stampX, stampY + 13, { align: "center" });
        

        
        // Add verification text
        doc.setFontSize(7);
        doc.setTextColor(...lightTextColor);
        doc.text(
          "Vérifiez l'authenticité de ce document sur www.ests.uca.ma avec le code de référence " + refNumber.split(": ")[1], 
          margin, 
          pageHeight - margin - 5
        );
        
        // Footer note
        doc.setFontSize(8);
        doc.setTextColor(...lightTextColor);
        doc.text(
          "Document généré électroniquement - Valable sans signature", 
          pageWidth / 2, 
          pageHeight - 10, 
          { align: "center" }
        );
        
        // Subtle watermark
        doc.setFontSize(70);
        doc.setTextColor(220, 230, 255);
        doc.setGState(new doc.GState({ opacity: 0.06 }));
        doc.text(
          "EST SAFI", 
          pageWidth / 2, 
          pageHeight / 2, 
          { 
            align: "center",
            angle: 45 
          }
        );
        
        // Reset opacity
        doc.setGState(new doc.GState({ opacity: 1 }));
        
        // Save the PDF with a proper filename
        doc.save(`Attestation_Scolarité_${username}_${new Date().toISOString().slice(0,10)}.pdf`);
        
        // Provide visual feedback that download started
        const originalText = btn.textContent;
        btn.textContent = "Téléchargement...";
        btn.style.backgroundColor = "#10B981"; // Green
        
        // Reset button after a short delay
        setTimeout(() => {
          btn.textContent = originalText;
          btn.style.backgroundColor = "#3b82f6";
        }, 2000);
        
      } catch (error) {
        console.error("Error generating PDF:", error);
        alert("Une erreur s'est produite lors de la génération du PDF. Veuillez réessayer.");
      }
    });
  });