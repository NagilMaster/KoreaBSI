import {
	createElement,
	useMemo,
	useState,
	useRef,
	useEffect,
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import { Overlay, OptionsPanel } from 'blocksy-options'
import ctEvents from 'ct-events'
import classnames from 'classnames'

import { getStableJsonKey } from 'ct-wordpress-helpers/get-stable-json-key'

const settingsCache = {}

const SettingsManager = () => {
	const [remoteItemData, setRemoteItemData] = useState({
		itemTitle: 'Name',
		itemId: null,
		depth: 0,
		data: null,
		parentData: null,
	})

	const [localItemSettings, setLocalItemSettigns] = useState(null)
	const [isLoading, setIsLoading] = useState(false)

	const actualData = useMemo(
		() => localItemSettings || remoteItemData.data,
		[localItemSettings, remoteItemData.data]
	)

	const isEditing = useMemo(
		() => !!(remoteItemData.itemId && actualData),
		[remoteItemData.itemId, actualData]
	)

	const containerRef = useRef()

	const persistItemSettings = async (itemId, settings, depth) => {
		settingsCache[
			getStableJsonKey({
				itemId,
				depth,
			})
		] = settings

		setIsLoading(true)

		fetch(
			`${wp.ajax.settings.url}?action=blocksy_ext_mega_menu_update_nav_item_setting&item_id=${itemId}`,
			{
				headers: {
					Accept: 'application/json',
					'Content-Type': 'application/json',
				},
				method: 'POST',
				body: JSON.stringify(settings),
			}
		).then(() => {
			setTimeout(() => {
				setIsLoading(false)
			}, 500)
		})
	}

	const loadItemSettings = async (itemId, depth, itemTitle) => {
		setLocalItemSettigns(null)

		let parentId = ''

		if (depth >= 1) {
			const item = document.querySelector(`#menu-item-${itemId}`)
			const parent = jQuery(item).prevAll('.menu-item-depth-0')[0]

			if (parent) {
				parentId = parent.id.replace('menu-item-', '')
			}
		}

		const cacheKey = getStableJsonKey({ itemId, depth })
		const parentCacheKey = getStableJsonKey({ itemId: parentId, depth: 0 })

		if (settingsCache[cacheKey]) {
			setRemoteItemData((remoteItemData) => ({
				...remoteItemData,
				itemTitle,
				itemId,
				depth,
				data: settingsCache[cacheKey],

				...(parentId && settingsCache[parentCacheKey]
					? {
							parentData: settingsCache[parentCacheKey],
					  }
					: {}),
			}))

			return
		} else {
			setRemoteItemData((remoteItemData) => ({
				...remoteItemData,
				itemTitle,
				itemId,
				depth,
				data: null,
				parentData: null,
			}))
		}

		const body = new FormData()

		body.append('action', 'blocksy_ext_mega_menu_get_nav_item_settings')
		body.append('item_id', itemId)

		if (parentId) {
			body.append('parent_item_id', parentId)
		}

		const response = await fetch(wp.ajax.settings.url, {
			method: 'POST',
			body,
		})

		if (response.status === 200) {
			const body = await response.json()

			if (body.success) {
				if (body.data.additional_items) {
					Object.keys(body.data.additional_items).map((item_id) => {
						settingsCache[
							getStableJsonKey({
								itemId: item_id.toString(),
								depth: 0,
							})
						] = body.data.additional_items[item_id]
					})
				}

				settingsCache[cacheKey] = body.data.settings

				setRemoteItemData((remoteItemData) => ({
					...remoteItemData,
					itemTitle,
					itemId,
					depth,
					data: settingsCache[cacheKey],

					...(parentId && settingsCache[parentCacheKey]
						? {
								parentData: settingsCache[parentCacheKey],
						  }
						: {}),
				}))
			}
		}
	}

	useEffect(() => {
		ctEvents.on(
			'blocksy:mega-menu:edit-item-settings',
			({ itemId, depth, itemTitle }) => {
				if (!itemId) {
					return
				}

				loadItemSettings(itemId, depth, itemTitle)
			}
		)
	}, [])

	const dismissModal = () => {
		setRemoteItemData((remoteItemData) => ({
			...remoteItemData,
			itemId: null,
		}))
	}

	return (
		<div>
			<Overlay
				items={isEditing}
				className="ct-admin-modal ct-mega-menu-modal"
				initialFocusRef={containerRef}
				onDismiss={() => {
					if (localItemSettings) {
						return
					}

					dismissModal()
				}}
				onCloseButtonClick={() => {
					dismissModal()
				}}
				render={() => (
					<div className="ct-modal-content" ref={containerRef}>
						<h2>
							{remoteItemData.itemTitle} -{' '}
							{__('Item Settings', 'blocksy-companion')}
						</h2>

						{null && <p>Level: {remoteItemData.depth + 1}</p>}

						<div className="ct-options-container ct-tabs-scroll">
							<OptionsPanel
								onChange={(optionId, optionValue) => {
									setLocalItemSettigns(
										(localItemSettings) => ({
											...(localItemSettings ||
												actualData),
											[optionId]: optionValue,
										})
									)
								}}
								options={
									blocksy_ext_mega_menu_localization.mega_menu_options
								}
								value={{
									...(Array.isArray(actualData) || !actualData
										? {}
										: actualData),

									...(remoteItemData.parentData
										? {
												parentData:
													remoteItemData.parentData,
										  }
										: {}),

									menu_item_level: remoteItemData.depth + 1,
								}}
								hasRevertButton={false}
							/>
						</div>

						<div className="ct-modal-actions has-divider">
							<button
								className={classnames(
									'button-primary ct-large-button'
								)}
								disabled={isLoading || !localItemSettings}
								onClick={() => {
									persistItemSettings(
										remoteItemData.itemId,
										actualData,
										remoteItemData.depth
									)

									setRemoteItemData((remoteItemData) => ({
										...remoteItemData,
										data: actualData,
									}))

									setLocalItemSettigns(null)
								}}>
								{isLoading ? (
									<svg
										width="15"
										height="15"
										viewBox="0 0 100 100">
										<g transform="translate(50,50)">
											<g transform="scale(1)">
												<circle
													cx="0"
													cy="0"
													r="50"
													fill="#687c93"
												/>
												<circle
													cx="0"
													cy="-26"
													r="12"
													fill="#ffffff"
													transform="rotate(161.634)">
													<animateTransform
														attributeName="transform"
														type="rotate"
														calcMode="linear"
														values="0 0 0;360 0 0"
														keyTimes="0;1"
														dur="1s"
														begin="0s"
														repeatCount="indefinite"
													/>
												</circle>
											</g>
										</g>
									</svg>
								) : (
									__('Save Settings', 'blocksy-companion')
								)}
							</button>
						</div>
					</div>
				)}
			/>
		</div>
	)
}

export default SettingsManager
