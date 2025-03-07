---
extends: _layouts.post 
title: We Have Datacenter at Home 
author: Xander Bazzi
date: 2023-11-20
collaborators: Xander Bazzi
image: /assets/img/infra_new.JPG
url: /projects/datacenter/index.html
section: content
---


# We Have Datacenter at Home

Digital technology is ubiquitous, and most of our daily life depends on it in some way.
Inevitably, this rapid digitalization of our world comes with the side effect of producing more data; and with it, the need to manage it. With the advent of Salesforce SaaS in the 90s, AWS in the early 2000s, and Azure in the past decade, it seems that the public cloud offered a viable solution to the data managament problem. However, as of recent, companies have been unmarrying from the cloud, with up to [33% percent of companies](https://journal.uptimeinstitute.com/high-costs-drive-cloud-repatriation-but-impact-is-overstated/) returning to their on-premises roots in 2022.

Motivated by the wave of businesses egressing from the cloud, and empowered by my DevOps expertise, I decided to take control of my data by self-hosting some infrastructure. The rack itself is my take on the [LackRack](https://wiki.eth0.nl/index.php/LackRack). Check this bad boy out:

![Datacenter Rack](/assets/img/infra_new.JPG)

From top to bottom: Workstation, patch panel, 24x 1Gbps + 4x 10Gbps Brocade ICX 6450, 8x 10Gbps SFP+ Mikrotik CRS309, 4x Lenovo USSF PCs, custom-built Supermicro server, PSU. Three of the Tiny PCs are running in a Proxmox VE cluster, running AlmaLinux VMs, which in turn run containers for some of my apps; the fourth Tiny PC is my OPNsense firewall. The staple of the infrastructure -- and the main reason I started self-hosting -- is the Supermicro server running TrueNAS SCALE. In addition to providing high-availability, multi-level caching, redundancy, and backups, it also runs several containers through the iX Apps market. Every device is fitted with a 10Gbps NIC and connected to the Mikrotik switch, with most ports set in trunk mode to allow any host/VM to join any VLAN. You might be wondering how I managed to fit 10Gbps cards in those tiny PCs. Well, it wasn't easy:

![Tiny with 10gbps](/assets/img/dc2.JPG)

Why even bother with 10Gbps? Is it just a frivolous attempt at flaunting how fast I can transfer big files across the LAN? Yes, but the main determinant factor for rationalizing the bigger bandwidth is centralized block storage for the VMs. To truly have a functional high availability system, we need the state to be stored in a separate host so that any VM can immediately become operational when spooled up, minimizing downtime in case of another VM crashing. Moreover, 10Gbps is a necessity to be able to access these block storage devices with similar throughput to local drives. Take the SATA III standard: the maximum theoretical bandwith is 6Gbps, so I know I can at least have networked block storage as fast as a local SATA drive. In TrueNAS, the most commonly and recently accessed data is cached by SSDs, and then by RAM. The NAS is running on DDR4, which has a maximum theoretical bandwidth of ~170GBps = 1360Gbps, which means the bottleneck is definitely the 10Gbps network link. Here's the proof, as reported by the Mikrotik switch during a backup job:

![Backups go brrr](/assets/img/bandwidth.png)