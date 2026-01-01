import { createAppKit } from '@reown/appkit'
import { Ethers5Adapter } from '@reown/appkit-adapter-ethers5'
import { mainnet, bsc, base } from '@reown/appkit/networks'

try {
    // Define AssetChain
    const assetChain = {
        id: 42420,
        name: 'Asset Chain Testnet',
        network: 'assetchain',
        nativeCurrency: {
            decimals: 18,
            name: 'Real World Asset',
            symbol: 'RWA',
        },
        rpcUrls: {
            default: { http: ['https://en-rpc.assetchain.org'] },
            public: { http: ['https://en-rpc.assetchain.org'] },
        },
        blockExplorers: {
            default: { name: 'Asset Chain Explorer', url: 'https://scan.assetchain.org' },
        },
    }

    // 1. Get projectId
    // Use the ID the user provided
    const projectId = 'fff1abc1e67efa89fda560a9fe393b8e'

    // 2. Create your application's metadata
    const metadata = {
        name: 'OnChain Bills',
        description: 'OnChain Bills App',
        url: window.location.origin, 
        icons: ['https://cdn-icons-png.flaticon.com/512/25/25231.png']
    }

    // 3. Create AppKit instance
    const modal = createAppKit({
        adapters: [new Ethers5Adapter()],
        networks: [mainnet, bsc, base, assetChain],
        metadata,
        projectId,
        features: {
            analytics: true 
        }
    })

    // Expose for usage in chainscript.php
    window.reownAppKit = modal;
    
    // Subscribe to state changes
    modal.subscribeState(state => {
        if (state.address) {
             if (typeof window.handleWalletConnection === 'function') {
                 if (window.userAddress !== state.address) {
                     window.handleWalletConnection(state.address);
                 }
             }
        } else {
             if (typeof window.disconnectWallets === 'function' && window.userAddress) {
                 window.disconnectWallets(); 
             }
        }
    })
    
    console.log("Reown AppKit initialized via bundle.");

} catch (err) {
    console.error("Reown AppKit Bundle Init Error:", err);
    window.reownError = err.message || JSON.stringify(err);
}
