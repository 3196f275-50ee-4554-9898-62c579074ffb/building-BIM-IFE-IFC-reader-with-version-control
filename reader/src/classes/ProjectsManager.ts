import { IProject, Project } from "./Project"

const file = await fetch("src/resource/NAV-IPI-ET1_E07-ZZZ-M3D-EST.ifc");
const buffer = await file.arrayBuffer();
const project1_data = new Uint8Array(buffer);

const file2 = await fetch("src/resource/HNS-CTL-MOD-EST-001.ifc")
const buffer2 = await file2.arrayBuffer();
const project2_data = new Uint8Array(buffer2)

const file3 = await fetch("src/resource/AdvancedProject.ifc")
const buffer3 = await file3.arrayBuffer();
const project3_data = new Uint8Array(buffer3)

export class ProjectsManager {
  list: Project[] = []
  onProjectCreated = (project: Project) => {}
  onProjectDeleted = () => {}

  constructor() {
    this.newProject({
      name: "Default Project",
      description: "This is just a default app project",
      status: "pending",
      userRole: "architect",
      finishDate: new Date(),
      ifc_data: project1_data
    })
    this.newProject({
      name: "Default Project2",
      description: "This is just a default app project",
      status: "active",
      userRole: "developer",
      finishDate: new Date(),
      ifc_data: project2_data
    })
    // console.log("project3_data", project3_data);
    this.newProject({
      name: "Building project",
      description: "This is just a default app project",
      status: "active",
      userRole: "developer",
      finishDate: new Date(),
      ifc_data: project3_data
    })
  }

  filterProjects(value: string) {
    const filteredProjects = this.list.filter((project) => {
      return project.name.includes(value)
    })
    return filteredProjects
  }

  newProject(data: IProject) {
    const projectNames = this.list.map((project) => {
      return project.name
    })
    const nameInUse = projectNames.includes(data.name)
    if (nameInUse) {
      if (this.list.length > 1) {
        const secondProject = this.list[1];
        console.log(`Opening second project: ${secondProject.name}`);
        // Set the second project as the currently active project (custom logic may be needed here)
        // For example, you might want to set some state or trigger a callback:
        // this.setActiveProject(secondProject.id); // Hypothetical function
      } else {
        console.log("There is no second project to open.");
      }
      return;
    }
    const project = new Project(data)
    this.list.push(project)
    this.onProjectCreated(project)
    return project
  }

  getProject(id: string) {
    const project = this.list.find((project) => {
      return project.id === id
    })
    return project
  }
  
  deleteProject(id: string) {
    const project = this.getProject(id)
    if (!project) { return }
    const remaining = this.list.filter((project) => {
      return project.id !== id
    })
    this.list = remaining
    this.onProjectDeleted()
  }
  
  exportToJSON(fileName: string = "projects") {
    const json = JSON.stringify(this.list, null, 2)
    const blob = new Blob([json], { type: 'application/json' })
    const url = URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = fileName
    a.click()
    URL.revokeObjectURL(url)
  }
  
  importFromJSON() {
    const input = document.createElement('input')
    input.type = 'file'
    input.accept = 'application/json'
    const reader = new FileReader()
    reader.addEventListener("load", () => {
      const json = reader.result
      if (!json) { return }
      const projects: IProject[] = JSON.parse(json as string)
      for (const project of projects) {
        try {
          this.newProject(project)
        } catch (error) {
          
        }
      }
    })
    input.addEventListener('change', () => {
      const filesList = input.files
      if (!filesList) { return }
      reader.readAsText(filesList[0])
    })
    input.click()
  }
}